<?php

namespace Service;

use \FPDF;

class PDF extends FPDF
{
    var $widths;
    var $aligns;
    // Background Fill Color
    var $backgrounds;
    // Border
    var $borders;
    var $fontz;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    /**
    * Função para aplicar alinhamentos na função Row().
    * @param mixed[] $a array ou string ('R' || 'L' || 'C' || ['R||L||R'])
    * @example SetAligns(['R', L, 'R', 'C']) - Congurações para quantidades exata de colunas.
    * @example SetAligns('C') - Centralizado para todos.
    */
    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function SetBackgrounds($bfc)
    {
        //Set the array of column alignments
        $this->backgrounds=$bfc;
    }

     /**
     * Array para aplicar borda de cada célula da função Row.
     * O símbolo '&|' significa que pode ser 'E ou OU'
     * @todo add an array parameter to border.
     * @param mixed[] $border int ou string (0 || 1, 'B &| L &| R &| T')
     * @example SetBorder([0, 1, 'TB', 'RL' , 'TBRL'])
     * @return array de string ou de int.
     */
    public function SetBorders($b)
    {
        //Set the array of borders
        $this->borders = $b;
    }

    function SetFontConfig($f){
        // Set the array of column fonts
        $this->fontz = $f;
    }

    function Row($data)
    {

        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++){
            // Seta a configuração de um array de fontes
            if (is_array($this->fontz[$i]))
                $this->SetFont($this->fontz[$i]['font'], $this->fontz[$i]['style'], $this->fontz[$i]['size']);
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); // retorna o maior número de linhas
        }

        $h=5*$nb;
        //Concatenate with blank for background fill
        for($i=0;$i<count($data);$i++)
        {
            $diff = $nb-$this->NbLines($this->widths[$i],$data[$i]); // diferença entre a maior linha e a linha atual
            if ($diff > 0)
            {
                for($j=0;$j<($diff);$j++)
                    $data[$i].="\n ";
            }
        }
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            // Alinhamentos em array ou string
              if (!is_array($this->aligns)){
                 $a= is_string($this->aligns) ? $this->aligns : false;
              }else{
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
              }
            // Array Background Fill Color
            if (!is_array($this->backgrounds)){
                $bfc= $this->backgrounds == true ? true : false;
            } else {
                $bfc=isset($this->backgrounds[$i]) ? $this->backgrounds[$i] : false;
            }
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            if (!isset($this->borders[$i])) {
                $this->Rect($x, $y, $w, $h);
            }
            // Array para setar bordas independentes
            if (!is_array($this->borders)) {
                $b = $this->borders == 1 ? 1 : 0;
            } else {
                $b = isset($this->borders[$i]) ? $this->borders[$i] : 0;
            }
            //Seta Fontes, Tamanhos e Formatos independentes
             if (is_array($this->fontz[$i]))
                $this->SetFont($this->fontz[$i]['font'], $this->fontz[$i]['style'], $this->fontz[$i]['size']);
            //Print the text
            $this->MultiCell($w,5,utf8_decode($data[$i]),$b,$a, $bfc);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Funções adicionais para calcular intervalos

    // Function for sum intervals of an array
    function array_sum_interval($array_external, $interval){

        $n_interval=explode(":", $interval);
        $sum = 0;
        for($i=$n_interval[0]; $i < ($n_interval[1]+1) ; $i++){
            $sum += $array_external[$i];
        }
        return $sum;

    }
    // Function for sum a interval of an array
    function array_sum_intervals($array_external, $intervals){

        $n_intervals=explode(";", $intervals);
        $array_amount = count($n_intervals);
        $result = 0;
        for($i=0; $i < $array_amount ; $i++){
            $result += $this->array_sum_interval($array_external, $n_intervals[$i]);
        }
        return $result;

    }

    // Matriz Transposta - transforma array dados de linhas em colunas
	function flipDiagonally($arr)
	{
		$out = array();
		foreach ($arr as $key => $subarr) {
			foreach ($subarr as $subkey => $subvalue) {
				$out[$subkey][$key] = $subvalue;
			}
		}
		return $out;
	}

}
