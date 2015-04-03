<?php

/* berita.html */
class __TwigTemplate_dcfb6a074057eccbb0d1899f2e7ab58d71572ebd98169b890550c63f15320230 extends Twig_Template
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
</head>
<body>
<div class=\"container\">
\t
\t";
        // line 15
        $this->env->loadTemplate("header.html")->display($context);
        // line 16
        echo "\t
\t<hr class=\"header\">
\t<div class=\"col-md-12\">
\t\t<div class=\"panel panel-default\">
\t\t\t<div class=\"panel-body\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t<h5>
\t\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-code fa-stack-1x fa-inverse\"></i></span>
\t\t\t\t\t\t";
        // line 24
        if (isset($context["judul"])) { $_judul_ = $context["judul"]; } else { $_judul_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_judul_), "html", null, true);
        echo "
\t\t\t\t\t\t<small class=\"btn-group pull-right\">
\t\t\t\t\t\t\t<a href=\"/";
        // line 26
        if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
        echo twig_escape_filter($this->env, $_type_, "html", null, true);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-newspaper-o\"></i> SEMUA ";
        if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_type_), "html", null, true);
        echo "</a>
\t\t\t\t\t\t</small>
\t\t\t\t\t</h5><hr class=\"main\">
\t\t\t\t\t<div class=\"col-md-2\" style=\"margin-bottom: 20px;\">
\t\t\t\t\t\t<img src=\"";
        // line 30
        if (isset($context["foto"])) { $_foto_ = $context["foto"]; } else { $_foto_ = null; }
        echo twig_escape_filter($this->env, $_foto_, "html", null, true);
        echo "\" alt=\"\" class=\"img-responsive\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-7\">
\t\t\t\t\t\t";
        // line 34
        echo "\t\t\t\t\t\t<div style=\"line-height: 1.3em;\">
\t\t\t\t\t\t\t";
        // line 35
        if (isset($context["pengantar"])) { $_pengantar_ = $context["pengantar"]; } else { $_pengantar_ = null; }
        if ($_pengantar_) {
            // line 36
            echo "\t\t\t\t\t\t\t<p class=\"lead well well-sm\">
\t\t\t\t\t\t\t";
            // line 37
            if (isset($context["pengantar"])) { $_pengantar_ = $context["pengantar"]; } else { $_pengantar_ = null; }
            echo $_pengantar_;
            echo "
\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t";
        }
        // line 40
        echo "\t\t\t\t\t\t\t<small class=\"text-muted pull-right\"><i class=\"fa fa-calendar\"></i> ";
        if (isset($context["tanggal"])) { $_tanggal_ = $context["tanggal"]; } else { $_tanggal_ = null; }
        echo $_tanggal_;
        echo "</small>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t\t<hr class=\"main\">
\t\t\t\t\t\t\t";
        // line 43
        if (isset($context["isi"])) { $_isi_ = $context["isi"]; } else { $_isi_ = null; }
        echo $_isi_;
        echo "
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<br>
\t\t\t\t\t\t";
        // line 47
        echo "\t\t\t\t\t\t<div style=\"margin-bottom: 15px;\">
\t\t\t\t\t\t\t";
        // line 48
        if (isset($context["tag"])) { $_tag_ = $context["tag"]; } else { $_tag_ = null; }
        if ($_tag_) {
            echo "<small class=\"text-muted\"><i class=\"fa fa-tags\"></i> ";
            if (isset($context["tag"])) { $_tag_ = $context["tag"]; } else { $_tag_ = null; }
            echo twig_escape_filter($this->env, $_tag_, "html", null, true);
            echo "</small><br>";
        }
        // line 49
        echo "\t\t\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t\t\t<a href=\"\" class=\"pull-left tooltips\" title=\"klik untuk mengirim pesan\">
\t\t\t\t\t\t\t\t\t<img src=\"";
        // line 51
        if (isset($context["foto_poster"])) { $_foto_poster_ = $context["foto_poster"]; } else { $_foto_poster_ = null; }
        echo twig_escape_filter($this->env, $_foto_poster_, "html", null, true);
        echo "\" alt=\"\" style=\"max-width: 36px; max-height: 36px; border-radius: 10%\">
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t\t\t<h4 class=\"media-heading\"><span class=\"\">Dikirim Oleh:</span><br><small><i class=\"fa fa-pencil-square\"></i> ";
        // line 54
        if (isset($context["nama_poster"])) { $_nama_poster_ = $context["nama_poster"]; } else { $_nama_poster_ = null; }
        echo twig_escape_filter($this->env, $_nama_poster_, "html", null, true);
        echo "</small></h4>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-3\">
\t\t\t\t\t\t<div class=\"well\">&nbsp;</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<br>
\t\t\t\t<hr class=\"main clearfix\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t<h5>
\t\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-comments fa-stack-1x fa-inverse\"></i></span>
\t\t\t\t\t\tKOMENTAR
\t\t\t\t\t</h5>
\t\t\t\t\t<div class=\"col-md-8\" style=\"margin-bottom: 15px;\">
\t\t\t\t\t\t<!-- disqus -->
\t\t\t\t\t\t
\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-4\">
\t\t\t\t\t\t<ul class=\"widget-products\">
\t\t\t\t\t\t\t";
        // line 77
        if (isset($context["other"])) { $_other_ = $context["other"]; } else { $_other_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_other_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 78
            echo "\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t<a href=\"";
            // line 79
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t\t<span class=\"img\"><img src=\"";
            // line 80
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\" class=\"img-responsive\"></span>
\t\t\t\t\t\t\t\t\t<span class=\"product clearfix\">
\t\t\t\t\t\t\t\t\t\t<span class=\"name\">";
            // line 82
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t<strong class=\"warranty text-muted\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-clock-o\"></i> ";
            // line 84
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
        // line 90
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
        // line 99
        $this->env->loadTemplate("footer.html")->display($context);
        // line 100
        echo "\t
</div>

";
        // line 103
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 104
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "berita.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 104,  214 => 103,  209 => 100,  207 => 99,  196 => 90,  183 => 84,  177 => 82,  171 => 80,  166 => 79,  163 => 78,  158 => 77,  131 => 54,  124 => 51,  120 => 49,  112 => 48,  109 => 47,  102 => 43,  94 => 40,  87 => 37,  84 => 36,  81 => 35,  78 => 34,  71 => 30,  60 => 26,  54 => 24,  44 => 16,  42 => 15,  35 => 10,  33 => 9,  25 => 5,  19 => 1,);
    }
}
