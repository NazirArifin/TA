<?php

/* index.html */
class __TwigTemplate_2f608d87a4a6edd0c3e7b686b331fe54a68c42d77057290ea3732b79d8a6fc9c extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\" data-ng-app=\"mdbz\" data-ng-controller=\"MainCtrl\" id=\"mdbz\">
<head>
\t<meta charset=\"UTF-8\">
\t<title>MADURA.BZ &mdash; Situs Jual Beli &amp; Direktori Bisnis Madura</title>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t
\t";
        // line 9
        $this->env->loadTemplate("pre-page.html")->display($context);
        // line 10
        echo "\t
</head>
<body>

<div class=\"container\">
\t
\t";
        // line 16
        $this->env->loadTemplate("header.html")->display($context);
        // line 17
        echo "\t
\t<hr class=\"header\">
\t<div class=\"row\">
\t\t<div class=\"col-md-6\">
\t\t\t<div class=\"panel panel-default\">
\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t<h3 class=\"panel-title\">
\t\t\t\t\t\t<a href=\"/berita\">Berita Bisnis</a>
\t\t\t\t\t\t<a href=\"/berita\" class=\"pull-right tooltips\" title=\"lihat semua\" data-placement=\"bottom\"><i class=\"fa fa-link\"></i></a>
\t\t\t\t\t</h3>
\t\t\t\t</div>
\t\t\t\t<div class=\"panel-body info-list\">
\t\t\t\t\t";
        // line 29
        if (isset($context["bisnis"])) { $_bisnis_ = $context["bisnis"]; } else { $_bisnis_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_bisnis_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 30
            echo "\t\t\t\t\t<a href=\"";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\" class=\"list-group-item\">
\t\t\t\t\t\t<h3 class=\"title\">";
            // line 31
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</h3>
\t\t\t\t\t\t<div class=\"clearfix\">
\t\t\t\t\t\t\t<img src=\"";
            // line 33
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\">
\t\t\t\t\t\t\t<div class=\"meta-info\">
\t\t\t\t\t\t\t\t<div class=\"date text-muted\"><i class=\"fa fa-calendar\"></i> ";
            // line 35
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
            echo "</div>
\t\t\t\t\t\t\t\t<div class=\"desc\">";
            // line 36
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "isi", array()), "html", null, true);
            echo "</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</a>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"col-md-6\">
\t\t\t<div class=\"panel panel-default\">
\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t<h3 class=\"panel-title\">
\t\t\t\t\t\t<a href=\"/info\">Sekilas Madura</a>
\t\t\t\t\t\t<a href=\"/info\" class=\"pull-right tooltips\" title=\"lihat semua\" data-placement=\"bottom\"><i class=\"fa fa-link\"></i></a>
\t\t\t\t\t</h3>
\t\t\t\t</div>
\t\t\t\t<div class=\"panel-body info-list\">
\t\t\t\t\t";
        // line 53
        if (isset($context["info"])) { $_info_ = $context["info"]; } else { $_info_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_info_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 54
            echo "\t\t\t\t\t<a href=\"";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\" class=\"list-group-item\">
\t\t\t\t\t\t<h3 class=\"title\">";
            // line 55
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</h3>
\t\t\t\t\t\t<div class=\"clearfix\">
\t\t\t\t\t\t\t<img src=\"";
            // line 57
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\">
\t\t\t\t\t\t\t<div class=\"meta-info\">
\t\t\t\t\t\t\t\t<div class=\"date text-muted\"><i class=\"fa fa-calendar\"></i> ";
            // line 59
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
            echo "</div>
\t\t\t\t\t\t\t\t<div class=\"desc\">";
            // line 60
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "isi", array()), "html", null, true);
            echo "</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</a>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 65
        echo "\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t<div class=\"row\">
\t\t<h2 class=\"text-center\">DIREKTORI BISNIS</h2>
\t\t<div class=\"col-md-8 col-md-offset-2\">
\t\t\t<form action=\"/direktori\">
\t\t\t\t<div class=\"input-group has-warning\">
\t\t\t\t\t<input type=\"text\" name=\"query\" class=\"form-control input-lg\" placeholder=\"Direktori yang Anda Cari?\">
\t\t\t\t\t<span class=\"input-group-btn\">
\t\t\t\t\t\t<button class=\"btn btn-default btn-lg\" type=\"submit\"><i class=\"fa fa-search\"></i> Cari</button>
\t\t\t\t\t</span>
\t\t\t\t</div>
\t\t\t</form>
\t\t</div>
\t\t<div class=\"text-center col-md-12\">
\t\t\t<ul class=\"pagination pagination-sm hidden-xs\">
\t\t\t\t";
        // line 84
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_direktori_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 85
            echo "\t\t\t\t<li";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if ( !$this->getAttribute($_c_, "h", array())) {
                echo " class=\"disabled\"";
            }
            echo "><a href=\"\" class=\"tooltips\" title=\"Lihat direktori ";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "a", array()), "html", null, true);
            echo "\"";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if ($this->getAttribute($_c_, "h", array())) {
                echo " data-ng-click=\"loadDirektoriList('";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "a", array()), "html", null, true);
                echo "')\"";
            }
            echo ">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "a", array()), "html", null, true);
            echo "</a></li>
\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 87
        echo "\t\t\t</ul>
\t\t\t<ul class=\"pagination pagination-sm visible-xs\">
\t\t\t\t";
        // line 89
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_direktori_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 90
            echo "\t\t\t\t";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if ($this->getAttribute($_c_, "h", array())) {
                echo "<li><a href=\"/direktori/";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "a", array()), "html", null, true);
                echo "\" class=\"tooltips\" title=\"Lihat direktori ";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "a", array()), "html", null, true);
                echo "\">";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "a", array()), "html", null, true);
                echo "</a></li>";
            }
            // line 91
            echo "\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 92
        echo "\t\t\t</ul>
\t\t\t<p class=\"visible-xs\">&nbsp;</p>
\t\t</div>
\t\t";
        // line 109
        echo "
\t\t<div class=\"col-md-8 col-md-offset-2\" data-ng-show=\"direktoriList.length > 0\" data-ng-cloak>
\t\t\t<table class=\"table table-condensed table-striped\">
\t\t\t\t<tbody>
\t\t\t\t\t<tr data-ng-repeat=\"c in direktoriList\">
\t\t\t\t\t\t<td data-ng-repeat=\"d in c\">
\t\t\t\t\t\t\t<a data-ng-href=\"/direktori/{{d.link}}\">
\t\t\t\t\t\t\t\t<strong data-ng-show=\"d.nama.length > 0\">&bull; {{d.nama}}</strong>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</td>
\t\t\t\t\t</tr>
\t\t\t\t</tbody>
\t\t\t</table>
\t\t</div>
\t\t";
        echo "
\t</div>
\t<hr class=\"main\">
\t<div class=\"row\">
\t\t<div class=\"col-md-6\">
\t\t\t<div class=\"panel panel-default\">
\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t<h3 class=\"panel-title\">
\t\t\t\t\t\t<a href=\"/jual\">Jual Barang</a>
\t\t\t\t\t\t<a href=\"/jual\" class=\"pull-right tooltips\" title=\"lihat semua\" data-placement=\"bottom\"><i class=\"fa fa-link\"></i></a>
\t\t\t\t\t</h3>
\t\t\t\t</div>
\t\t\t\t<div class=\"panel-body\" scrollable data-height=\"400px\">
\t\t\t\t\t";
        // line 122
        if (isset($context["jual"])) { $_jual_ = $context["jual"]; } else { $_jual_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_jual_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 123
            echo "\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t<a class=\"media-left\" href=\"";
            // line 124
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t<img src=\"";
            // line 125
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" class=\"img-rounded\" alt=\"\" style=\"width: 54px;\">
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t<h4 class=\"media-heading\"><a href=\"";
            // line 128
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</a></h4>
\t\t\t\t\t\t\t<p class=\"text-justify\">";
            // line 129
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "isi", array()), "html", null, true);
            echo "</p>
\t\t\t\t\t\t\t<p class=\"text-muted sender\"><i class=\"fa fa-edit\"></i> <a href=\"";
            // line 130
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link_angg", array()), "html", null, true);
            echo "\">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "anggota", array()), "html", null, true);
            echo "</a> &mdash; ";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
            echo "</p></p>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 134
        echo "\t\t\t\t</div>
\t\t\t\t<div class=\"panel-footer\">
\t\t\t\t\t<a href=\"/jual\"><i class=\"fa fa-angle-right\"></i> Tampilkan Semua</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"col-md-6\">
\t\t\t<div class=\"panel panel-default\">
\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t<h3 class=\"panel-title\">
\t\t\t\t\t\t<a href=\"/beli\">Beli Barang</a>
\t\t\t\t\t\t<a href=\"/beli\" class=\"pull-right tooltips\" title=\"lihat semua\" data-placement=\"bottom\"><i class=\"fa fa-link\"></i></a>
\t\t\t\t\t</h3>
\t\t\t\t</div>
\t\t\t\t<div class=\"panel-body\" scrollable data-height=\"400px\">
\t\t\t\t\t";
        // line 149
        if (isset($context["beli"])) { $_beli_ = $context["beli"]; } else { $_beli_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_beli_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 150
            echo "\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t<a class=\"media-left\" href=\"";
            // line 151
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t<img src=\"";
            // line 152
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" class=\"img-rounded\" alt=\"\" style=\"width: 54px;\">
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t<h4 class=\"media-heading\"><a href=\"";
            // line 155
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</a></h4>
\t\t\t\t\t\t\t<p class=\"text-justify\">";
            // line 156
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "isi", array()), "html", null, true);
            echo "</p>
\t\t\t\t\t\t\t<p class=\"text-muted sender\"><i class=\"fa fa-edit\"></i> <a href=\"";
            // line 157
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link_angg", array()), "html", null, true);
            echo "\">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "anggota", array()), "html", null, true);
            echo "</a> &mdash; ";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
            echo "</p></p>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 161
        echo "\t\t\t\t</div>
\t\t\t\t<div class=\"panel-footer\">
\t\t\t\t\t<a href=\"/beli\"><i class=\"fa fa-angle-right\"></i> Tampilkan Semua</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t<h2 class=\"text-center\">ETALASE</h2>
\t<div class=\"row\">
\t\t";
        // line 171
        if (isset($context["produk"])) { $_produk_ = $context["produk"]; } else { $_produk_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_produk_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 172
            echo "\t\t<div class=\"col-md-6\">
\t\t\t<div class=\"panel panel-default\">
\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t<a class=\"media-left\" href=\"";
            // line 176
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t<img src=\"";
            // line 177
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" class=\"img-rounded\" alt=\"\" style=\"width: 64px;\">
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t<h4 class=\"media-heading produk\">
\t\t\t\t\t\t\t\t<a href=\"";
            // line 181
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "nama", array()), "html", null, true);
            echo "</a>
\t\t\t\t\t\t\t\t";
            // line 182
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_c_, "stok", array()) > 0)) {
                echo "<small class=\"label label-warning pull-right\">TERSEDIA</small>";
            }
            // line 183
            echo "\t\t\t\t\t\t\t\t";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_c_, "stok", array()) == 0)) {
                echo "<small class=\"label label-danger pull-right\">TERJUAL</small>";
            }
            // line 184
            echo "\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t<p>";
            // line 185
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "info", array()), "html", null, true);
            echo "</p>
\t\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t\t<strong class=\"\">Rp. ";
            // line 187
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "harga", array()), "html", null, true);
            echo "</strong>
\t\t\t\t\t\t\t\t";
            // line 188
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if (($this->getAttribute($_c_, "stok", array()) > 0)) {
                // line 189
                echo "\t\t\t\t\t\t\t\t<button class=\"btn btn-primary btn-xs pull-right\" data-ng-click=\"addItem(";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "id", array()), "html", null, true);
                echo ")\" data-ng-hide=\"itemTaken(";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "id", array()), "html", null, true);
                echo ")\">TAMBAH KE KERANJANG <i class=\"fa fa-cart-plus\"></i></button>
\t\t\t\t\t\t\t\t";
            }
            // line 191
            echo "\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 198
        echo "\t\t<div class=\"col-md-12\">
\t\t\t<p class=\"text-center\">
\t\t\t\t<a href=\"/fproduk\" class=\"btn btn-default\"><i class=\"fa fa-search\"></i> LIHAT SEMUA PRODUK</a> 
\t\t\t\t<button class=\"btn btn-default\"><i class=\"fa fa-download\"></i> UNDUH KATALOG</button>
\t\t\t</p>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t
\t";
        // line 207
        $this->env->loadTemplate("footer.html")->display($context);
        // line 208
        echo "\t
</div>

";
        // line 211
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 212
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  497 => 212,  495 => 211,  490 => 208,  488 => 207,  477 => 198,  465 => 191,  455 => 189,  452 => 188,  447 => 187,  441 => 185,  438 => 184,  432 => 183,  427 => 182,  419 => 181,  411 => 177,  406 => 176,  400 => 172,  395 => 171,  383 => 161,  366 => 157,  361 => 156,  353 => 155,  346 => 152,  341 => 151,  338 => 150,  333 => 149,  316 => 134,  299 => 130,  294 => 129,  286 => 128,  279 => 125,  274 => 124,  271 => 123,  266 => 122,  236 => 109,  231 => 92,  225 => 91,  210 => 90,  205 => 89,  201 => 87,  175 => 85,  170 => 84,  149 => 65,  137 => 60,  132 => 59,  126 => 57,  120 => 55,  114 => 54,  109 => 53,  95 => 41,  83 => 36,  78 => 35,  72 => 33,  66 => 31,  60 => 30,  55 => 29,  41 => 17,  39 => 16,  31 => 10,  29 => 9,  19 => 1,);
    }
}
