<?php

/* header.html */
class __TwigTemplate_ba5c44cf0c908bd4d89265ea6d011affcd32f9d199103fda4ddc2a889d9d30ca extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "
";
        // line 2
        if (isset($context["authenticate"])) { $_authenticate_ = $context["authenticate"]; } else { $_authenticate_ = null; }
        if ($_authenticate_) {
            // line 3
            echo "
<div class=\"row\">
\t<div class=\"col-md-8\">
\t\t<a href=\"/\" class=\"pull-left hidden-xs\"><img src=\"/img/logo-long.png\" alt=\"\"></a>
\t\t<h4 class=\"page-title text-center\" style=\"margin-top: 0; line-height: 0.5em;\">
\t\t\t<!--<small class=\"text-muted\" style=\"font-size: 0.55em;\"><i class=\"fa fa-heartbeat\"></i> anda login sebagai:</small>--><br>
\t\t\t";
            // line 9
            if (isset($context["member_valid"])) { $_member_valid_ = $context["member_valid"]; } else { $_member_valid_ = null; }
            if ($_member_valid_) {
                echo "<i class=\"fa fa-check-circle text-primary\"></i> ";
            }
            if (isset($context["member_nama"])) { $_member_nama_ = $context["member_nama"]; } else { $_member_nama_ = null; }
            echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_member_nama_), "html", null, true);
            echo "
\t\t\t<br><br>
\t\t\t<a href=\"/home\" class=\"tooltips\" title=\"beranda\" data-placement=\"bottom\"><span class=\"fa-stack\"><i class=\"fa fa-circle fa-stack-2x\"></i><i class=\"fa fa-home fa-stack-1x fa-inverse\"></i></span></a>
\t\t</h4>
\t\t<!--<p class=\"text-muted pull-left\">
\t\t\tProfil Anda tidak lengkap.
\t\t</p>-->
\t</div>
\t<div class=\"col-md-4 col-xs-12\">
\t\t<ul class=\"nav nav-pills top-menu\">
\t\t\t<li role=\"presentation\"><a href=\"#\"><i class=\"fa fa-envelope-o\"></i> PESAN <span class=\"label label-danger\">3</span></a></li>
\t\t\t<li role=\"presentation\"><a href=\"#\"><i class=\"fa fa-paint-brush\"></i> EDIT PROFIL</a></li>
\t\t\t<li role=\"presentation\"><a href=\"\" data-ng-click=\"logout()\"><i class=\"fa fa-power-off\"></i> LOGOUT</a></li>
\t\t</ul>
\t\t";
            // line 29
            echo "
\t\t<a href=\"/checkout\" class=\"btn btn-default btn-lg pull-right\">
\t\t\t<span class=\"label\" data-ng-class=\"item.length > 0 ? 'label-warning' : 'label-default'\">{{item.length}}</span> &nbsp;BARANG 
\t\t\t<!--<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-shopping-cart fa-stack-1x fa-inverse\"></i></span>-->
\t\t\t<i class=\"fa fa-shopping-cart fa-lg\"></i>
\t\t</a>
\t\t";
            echo "
\t\t<a href=\"/anggota/";
            // line 30
            if (isset($context["member_kode"])) { $_member_kode_ = $context["member_kode"]; } else { $_member_kode_ = null; }
            echo twig_escape_filter($this->env, $_member_kode_, "html", null, true);
            echo "\" class=\"btn btn-default btn-lg pull-right tooltips\" title=\"lihat profil\" data-placement=\"bottom\">
\t\t\t<i class=\"fa fa-street-view fa-lg text-primary\"></i>
\t\t</a>
\t</div>
</div>

";
        } else {
            // line 37
            echo "<!-- belum login -->

<div class=\"row\">
\t<div class=\"col-md-9\">
\t\t<a href=\"/\" class=\"pull-left hidden-xs\"><img src=\"/img/logo-long.png\" alt=\"\"></a>
\t\t<h3 class=\"page-title pull-left\">
\t\t\tMADURA.BZ &mdash; JUAL BELI &amp; DIREKTORI BISNIS MADURA<br>
\t\t\t<small class=\"text-muted\"><em><i class=\"fa fa-quote-left\"></i> Pengembangan ekonomi kedaerahan secara global</em></small>
\t\t</h3>
\t</div>
\t<div class=\"col-md-3\">
\t\t<ul class=\"nav nav-pills pull-right\">
\t\t\t";
            // line 49
            if (isset($context["registering"])) { $_registering_ = $context["registering"]; } else { $_registering_ = null; }
            if ( !$_registering_) {
                // line 50
                echo "\t\t\t<li role=\"presentation\"><a href=\"/daftar\"><i class=\"fa fa-pencil-square\"></i> DAFTAR</a></li>
\t\t\t<li role=\"presentation\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#login\"><i class=\"fa fa-sign-in\"></i> LOGIN</a></li>
\t\t\t";
            } else {
                // line 53
                echo "\t\t\t<li role=\"presentation\">&nbsp;</li>
\t\t\t";
            }
            // line 55
            echo "\t\t</ul>
\t\t
\t\t";
            // line 63
            echo "
\t\t<button type=\"button\" class=\"btn btn-default btn-lg pull-right\">
\t\t\t<span class=\"label\" data-ng-class=\"item.length > 0 ? 'label-warning' : 'label-default'\">{{item.length}}</span> &nbsp;BARANG 
\t\t\t<!--<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-shopping-cart fa-stack-1x fa-inverse\"></i></span>-->
\t\t\t<i class=\"fa fa-shopping-cart fa-lg\"></i>
\t\t</button>
\t\t";
            echo "
\t</div>
</div>

";
        }
    }

    public function getTemplateName()
    {
        return "header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 63,  102 => 55,  98 => 53,  93 => 50,  90 => 49,  76 => 37,  65 => 30,  55 => 29,  33 => 9,  25 => 3,  22 => 2,  19 => 1,);
    }
}
