<?php

namespace App\Behavior;

class LabelsBehavior {

    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe SpeciesController
    public static $LABEL_ADD_SPECIE_SUCCESS = "* Espécie <strong>%s</strong> adicionada com sucesso!";
    public static $LABEL_ADD_SPECIE_ERROR = "* Este nome <strong>%s</strong> já existe, por favor, informe outro nome e tente novamente!";
    public static $LABEL_EDIT_SPECIE_SUCCESS = "* A espécie <strong>%s</strong> atualiza com sucesso para <strong>%s</strong>.";
    public static $LABEL_DEL_SPECIE_SUCCESS = "* A espécie de nome <strong>%s</strong> foi excluída com sucesso!";
    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe ShipsController
    public static $LABEL_ADD_SHIP_SUCCESS = "* Embarcação <strong>%s</strong> adicionada com sucesso!";
    public static $LABEL_ADD_SHIP_ERROR = "* A embarcação <strong>%s</strong> com o registro <strong>%s</strong> já está cadastrada, por favor verifique e tente novamente!";
    public static $LABEL_EDIT_SHIP_SUCCESS = "* Embarcação <strong>%s</strong> atualiza com sucesso!";
    public static $LABEL_EDIT_SHIP_ERROR = "* O registro <strong>%s</strong> fornecido para a embarcação <strong>%s</strong> já existe, por favor verifique e tente novamente!";
    public static $LABEL_DEL_SHIP_SUCCESS = "* A embarcação de nome <strong>%s</strong> foi excluída com sucesso!";
    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe ShipownersController
    public static $LABEL_ADD_SHIPOWNER_SUCCESS = "* Armador <strong>%s</strong> adicionado com sucesso!";
    public static $LABEL_ADD_SHIPOWNER_ERROR = "* O armador <strong>%s</strong> com o registro <strong>%s</strong> já está cadastrado, por favor verifique e tente novamente!";
    public static $LABEL_EDIT_SHIPOWNER_SUCCESS = "* Armador <strong>%s</strong> atualiza com sucesso!";
    public static $LABEL_EDIT_SHIPOWNER_ERROR = "* O registro <strong>%s</strong> fornecido para o armador <strong>%s</strong> já existe, por favor verifique e tente novamente!";
    public static $LABEL_DEL_SHIPOWNER_SUCCESS = "* O armador de nome <strong>%s</strong> foi excluído com sucesso!";
    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe DocsController
    public static $LABEL_ADD_DOCS_SUCCESS = "* O documento nº <strong>%s</strong> foi criado com sucesso!";
    public static $LABEL_EDIT_DOCS_SUCCESS = "* O documento nº <strong>%s</strong> foi atualizado com sucesso!";
    public static $LABEL_DEL_DOCS_SUCCESS = "* O documento nº <strong>%s</strong> foi excluido com sucesso! Essa ação não pode ser desfeita.";
    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe SolicitationsController
    public static $LABEL_ADD_SOLICITATION_SUCCESS = "* A solicitação <strong>%s</strong> foi realizada com sucesso!";
    public static $LABEL_EDIT_SOLICITATION_SUCCESS = "* A solicitação <strong>%s</strong> foi atualizada com sucesso!";
    public static $LABEL_DEL_SOLICITATION_SUCCESS = "* A solicitação <strong>%s</strong> foi excluida com sucesso! Essa ação não pode ser desfeita.";
    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe PortsController
    public static $LABEL_ADD_PORTS_SUCCESS = "* O porto de nome <strong>%s</strong> foi adicionado a lista com sucesso!";
    public static $LABEL_ADD_PORTS_ERROR = "* O nome <strong>%s</strong> de porto já existe, por favor verifique e tente novamente!";
    public static $LABEL_EDIT_PORTS_SUCCESS  = "* O porto de nome <strong>%s</strong> foi atualizado com sucesso!";
    public static $LABEL_EDIT_PORTS_ERROR = "* O nome <strong>%s</strong> de porto já existe, por favor verifique e tente novamente!";
    public static $LABEL_DEL_PORT_SUCCESS = "* O porto <strong>%s</strong> foi excluido com sucesso! Essa ação não pode ser desfeita.";
    //Use o simbolo "%s" sem aspas para passar um valor dinâmico ao texto.
    //Textos padrões para a classe PortsController
    public static $LABEL_ADD_HOOKS_SUCCESS = "* Lance adicionado com sucesso!";
    public static $LABEL_DEL_HOOKS_SUCCESS = "* A registro de número <strong>%s</strong> foi excluído com sucesso! Essa ação não pode ser desfeita.";
    public static $LABEL_EDIT_HOOK_SUCCESS = "* A registro de número <strong>%s</strong> foi atualizado com sucesso!";
    public static $LABEL_EDIT_HOOK_ERROR = "* A registro de número <strong>%s</strong> não pode ser atualizado! Verifique os campos ou entre em contato com o administrador.";

}
