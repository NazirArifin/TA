<?php

/* kiriman.html */
class __TwigTemplate_d62a2f708403cf49f2b11203a151d523690a5ba1fb49a13efb89e1c610af3cbf extends Twig_Template
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
\t<title>MADURA.BZ &mdash; ";
        // line 5
        if (isset($context["judul"])) { $_judul_ = $context["judul"]; } else { $_judul_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_judul_), "html", null, true);
        echo "</title>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t
\t";
        // line 9
        $this->env->loadTemplate("pre-page.html")->display($context);
        // line 10
        echo "\t
<script>
\twindow.post = '";
        // line 12
        if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
        echo twig_escape_filter($this->env, $_id_, "html", null, true);
        echo "';
\twindow.member = '";
        // line 13
        if (isset($context["member_kode"])) { $_member_kode_ = $context["member_kode"]; } else { $_member_kode_ = null; }
        echo twig_escape_filter($this->env, $_member_kode_, "html", null, true);
        echo "';
\twindow.poster = '";
        // line 14
        if (isset($context["poster_kode"])) { $_poster_kode_ = $context["poster_kode"]; } else { $_poster_kode_ = null; }
        echo twig_escape_filter($this->env, $_poster_kode_, "html", null, true);
        echo "';
</script>
\t
</head>
<body>
<div class=\"container\">
\t
\t";
        // line 21
        $this->env->loadTemplate("header.html")->display($context);
        // line 22
        echo "\t
\t<hr class=\"header\">
\t<div class=\"col-md-12\">
\t\t<div class=\"panel panel-default\">
\t\t\t<div class=\"panel-body\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t<h5>
\t\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-code fa-stack-1x fa-inverse\"></i></span>
\t\t\t\t\t\t";
        // line 30
        if (isset($context["judul"])) { $_judul_ = $context["judul"]; } else { $_judul_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_judul_), "html", null, true);
        echo "
\t\t\t\t\t\t<small class=\"btn-group pull-right\">
\t\t\t\t\t\t\t<a href=\"";
        // line 32
        if (isset($context["poster_link"])) { $_poster_link_ = $context["poster_link"]; } else { $_poster_link_ = null; }
        echo twig_escape_filter($this->env, $_poster_link_, "html", null, true);
        echo "\" class=\"btn btn-warning\"><i class=\"fa fa-user\"></i> ";
        if (isset($context["poster_nama"])) { $_poster_nama_ = $context["poster_nama"]; } else { $_poster_nama_ = null; }
        echo twig_escape_filter($this->env, $_poster_nama_, "html", null, true);
        echo "</a>
\t\t\t\t\t\t</small>
\t\t\t\t\t</h5><hr class=\"main\">
\t\t\t\t\t<div class=\"pull-left col-md-2\">
\t\t\t\t\t\t<img src=\"";
        // line 36
        if (isset($context["foto"])) { $_foto_ = $context["foto"]; } else { $_foto_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_foto_, 0, array(), "array"), "html", null, true);
        echo "\" alt=\"\" class=\"img-responsive zoomable-gallery\" data-zoom-image=\"";
        if (isset($context["foto"])) { $_foto_ = $context["foto"]; } else { $_foto_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_foto_, 0, array(), "array"), "html", null, true);
        echo "\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-7\">
\t\t\t\t\t\t";
        // line 40
        echo "\t\t\t\t\t\t<div style=\"line-height: 1.3em;\">
\t\t\t\t\t\t\t<!--<small class=\"text-muted\"><i class=\"fa fa-tags\"></i> Burung</small>-->
\t\t\t\t\t\t\t<small class=\"text-muted pull-right\"><i class=\"fa fa-calendar\"></i> ";
        // line 42
        if (isset($context["tanggal"])) { $_tanggal_ = $context["tanggal"]; } else { $_tanggal_ = null; }
        echo $_tanggal_;
        echo "</small>
\t\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t\t<div class=\"well well-sm\">
\t\t\t\t\t\t\t";
        // line 45
        if (isset($context["isi"])) { $_isi_ = $context["isi"]; } else { $_isi_ = null; }
        echo $_isi_;
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
        // line 49
        echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-3\">
\t\t\t\t\t\t<div class=\"well\">&nbsp;</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"clearfix\"></div>
\t\t\t\t<ul id=\"gallery\" class=\"clearfix\">
\t\t\t\t\t";
        // line 56
        if (isset($context["foto"])) { $_foto_ = $context["foto"]; } else { $_foto_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_foto_);
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 57
            echo "\t\t\t\t\t<li id=\"0";
            if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index", array()), "html", null, true);
            echo "\" class=\"col-md-2 col-sm-3 col-xs-6\">
\t\t\t\t\t\t<a href=\"\" data-zoom-image=\"";
            // line 58
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $_c_, "html", null, true);
            echo "\" data-image=\"";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $_c_, "html", null, true);
            echo "\"><div class=\"photo-box\" style=\"background-image: url('";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $_c_, "html", null, true);
            echo "');\"></div></a>
\t\t\t\t\t</li>
\t\t\t\t\t";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        echo "\t\t\t\t</ul>
\t\t\t\t<hr class=\"main\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t<h5>
\t\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-comments fa-stack-1x fa-inverse\"></i></span>
\t\t\t\t\t\tKOMENTAR
\t\t\t\t\t</h5>
\t\t\t\t\t<div class=\"col-md-6\" style=\"margin-bottom: 15px;\" data-ng-controller=\"KomentarCtrl\" data-ng-cloak>
\t\t\t\t\t\t";
        // line 86
        echo "
\t\t\t\t\t\t<div class=\"well\" data-ng-hide=\"komentarList\">
\t\t\t\t\t\t\t<h3 class=\"text-center text-info\"><i class=\"fa fa-file-o\"></i> Belum ada Komentar</h3>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<ul class=\"media-list\">
\t\t\t\t\t\t\t<li class=\"media\" data-ng-repeat=\"c in komentarList\">
\t\t\t\t\t\t\t\t<a data-ng-href=\"{{c.link}}\" class=\"pull-left\">
\t\t\t\t\t\t\t\t\t<img data-ng-src=\"{{c.foto}}\" alt=\"\" class=\"media-object\">
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t\t\t<h4 class=\"media-heading\" style=\"margin-bottom: 10px\"><a data-ng-href=\"{{c.link}}\"><span data-ng-show=\"c.valid\"><i class=\"fa fa-check-circle\"></i> </span>{{c.nama}}</a></h4>
\t\t\t\t\t\t\t\t\t<p style=\"width: 100%\" data-ng-bind-html=\"c.isi\">{{c.isi}}</p>
\t\t\t\t\t\t\t\t\t<small class=\"text-muted pull-left\" style=\"font-size: 0.87em\"><i class=\"fa fa-clock-o\"></i> {{c.tanggal}}</small>
\t\t\t\t\t\t\t\t\t<small class=\"pull-left\" style=\"margin-left: 10px;\"><a href=\"\" data-ng-show=\"c.hapus\" delete-data=\"{{c.id}}\" data-type=\"komentar\"><i class=\"fa fa-trash-o\"></i> Hapus</a></small>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t\t";
        echo "
\t\t\t\t\t\t";
        // line 87
        if (isset($context["authenticate"])) { $_authenticate_ = $context["authenticate"]; } else { $_authenticate_ = null; }
        if ($_authenticate_) {
            // line 88
            echo "\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<hr class=\"main\">
\t\t\t\t\t\t\t<form>
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<textarea name=\"\" id=\"\" cols=\"30\" rows=\"4\" class=\"form-control\" placeholder=\"\" data-ng-model=\"komentar\"></textarea>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"clearfix\">
\t\t\t\t\t\t\t\t\t<button class=\"btn btn-success pull-right\" save-komentar><i class=\"fa fa-check\"></i> Tambahkan Komentar</button>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
        }
        // line 100
        echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-3\">
\t\t\t\t\t\t<ul class=\"widget-products\">
\t\t\t\t\t\t\t";
        // line 103
        if (isset($context["other1"])) { $_other1_ = $context["other1"]; } else { $_other1_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_other1_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 104
            echo "\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t<a href=\"";
            // line 105
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t\t<span class=\"img\"><img src=\"";
            // line 106
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\"></span>
\t\t\t\t\t\t\t\t\t<span class=\"product clearfix\">
\t\t\t\t\t\t\t\t\t\t<span class=\"name\">";
            // line 108
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t<strong class=\"warranty text-muted\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-clock-o\"></i> ";
            // line 110
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t\t\t\t</strong>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 116
        echo "\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-3\">
\t\t\t\t\t\t<ul class=\"widget-products\">
\t\t\t\t\t\t\t";
        // line 120
        if (isset($context["other2"])) { $_other2_ = $context["other2"]; } else { $_other2_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_other2_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 121
            echo "\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t<a href=\"";
            // line 122
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t\t<span class=\"img\"><img src=\"";
            // line 123
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\"></span>
\t\t\t\t\t\t\t\t\t<span class=\"product clearfix\">
\t\t\t\t\t\t\t\t\t\t<span class=\"name\">";
            // line 125
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t<strong class=\"warranty text-muted\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-clock-o\"></i> ";
            // line 127
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t\t\t\t</strong>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 133
        echo "\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t
\t\t\t</div>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t
\t";
        // line 142
        $this->env->loadTemplate("footer.html")->display($context);
        // line 143
        echo "\t
</div>

";
        // line 146
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 147
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "kiriman.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  329 => 147,  327 => 146,  322 => 143,  320 => 142,  309 => 133,  296 => 127,  290 => 125,  284 => 123,  279 => 122,  276 => 121,  271 => 120,  265 => 116,  252 => 110,  246 => 108,  240 => 106,  235 => 105,  232 => 104,  227 => 103,  222 => 100,  208 => 88,  205 => 87,  184 => 86,  174 => 61,  150 => 58,  144 => 57,  126 => 56,  117 => 49,  110 => 45,  103 => 42,  99 => 40,  89 => 36,  78 => 32,  72 => 30,  62 => 22,  60 => 21,  49 => 14,  44 => 13,  39 => 12,  35 => 10,  33 => 9,  25 => 5,  19 => 1,);
    }
}
