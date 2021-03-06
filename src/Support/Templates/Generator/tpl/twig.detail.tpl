{#************************************************************
 * SCRIPT CRIADO PELO GERADOR DE CÓDIGO v{%GC_VERSION%}
 * CRIADO EM: {%GC_DATE%}
 * GERADO POR: {%GC_DEVELOPER%} @ {%GC_MACHINE%}
 ************************************************************#}

{% extends "index.twig" %}
{% block content %}

    {{ flash | raw }}

    {# DETALHES #}
    <div class="row">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalhe do {{controller}}</h3>
                </div>
                <div class="panel-body">
                    {%HTMLDetail%}

                    {% if validarAcesso() %}
                        <div class="right">
                            {%HTMLDetailBtn%}
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>
    </div>

    {# ABAS #}
    <div class="row">
        <div class="container">

            <div class="painel-nav">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="#aba1" data-toggle="tab" class="active">ABA 1</a>
                    </li>
                    <li>
                        <a href="#aba2" data-toggle="tab">ABA 2</a>
                    </li>
                    {% if validarAcesso() %}
                        <li>
                            <a href="#aba3" data-toggle="tab">ABA 3</a>
                        </li>
                    {% endif %}

                </ul>
                <div class="tab-content">
                    <div id="aba1" class="tab-pane active">
                            {# CONTEUDO ABA 1 #}

                            <div class="row">
                                {% if validarAcesso() %}
                                    <button id="form-aba1-grid-show" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        {{langApp.new}}
                                    </button>

                                    <div id="form-aba1-grid"  style="display:none; width:100%; padding-top:10px; padding-bottom:10px;">
                                        <form class="form-aba1" role="form" novalidate>

                                            <input type="hidden" name="edit" id="edit" value="" />
                                            <input type="hidden" name="CAMPO_ESCONDIDO" value="{{CAMPO_ESCONDIDO}}" id="CAMPO_ESCONDIDO"/>

                                            <div class="form-group">
                                                <label for="CAMPO_ABA1" class="obrigatorio">CAMPO_ABA1</label>
                                                <input type="text" class="form-control" name="CAMPO_ABA1" id="CAMPO_ABA1" placeholder="Entre com o valor" required>
                                            </div>


                                            <a id="form-aba1-grid-cancel" class="btn btn-default left">
                                                <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                                {{langApp.cancel}}
                                            </a>

                                            <button id="form-aba1-add" class="btn btn-success right">
                                                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                {{langApp.save}}
                                            </button>

                                        </form>
                                    </div>
                                {% endif %}
                            </div>

                            {# TABELA DE PESQUISA #}
                            <div class="row">
                                <table class="listview table table-striped table-hover">
                                    <thead id="tabela-header">
                                        <tr>
                                            <th>#</th>
                                            <th>NOME CAMPO</th>

                                            <th>AÇÕES</th>
                                        </tr>
                                        <tr class="search-fields">
                                            <form class="form-fields-aba1">
                                                <input type="hidden" name="CAMPO_ABA1" value="{{CAMPO_ABA1}}" id="CAMPO_ABA1"/>

                                                <td><input name="TABELA.CAMPO_ABA1:ANY" class="form-control" type='text'/></td>
                                                <td><input name="TABELA.CAMPO_ABA1:ANY" class="form-control" type='text'/></td>

                                                <td style='width:150px !important;'>

                                                    <button type="button" class="btn btn-primary search-aba1">
                                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                    </button>

                                                    <button type="button" class="btn btn-default search-aba1-refresh">
                                                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                                    </button>

                                                    <button type="button" class="btn btn-default" id="imprimir-aba1">
                                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    </button>

                                                </td>
                                            </form>
                                        </tr>
                                    </thead>
                                    <tbody id="tabela-aba1"></tbody>
                                </table>
                            </div>
                            {# FIM TABELA PESQUISA#}

                            {# FIM CONTEUDO EXEMPLO ABA 1 #}
                    </div>

                    <div id="aba2" class="tab-pane">
                        <div class="row">
                            {# CONTEUDO ABA 2 #}
                        </div>
                    </div>

                    {% if validarAcesso() %}
                        <div id="aba3" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12">

                                    {# CONTEUDO ABA 3 #}

                                </div>
                            </div>
                        </div>
                    {% endif %}

                </div>
            </div>

        </div>
    </div>
{% endblock %}
