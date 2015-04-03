<?php

/* berita-search.html */
class __TwigTemplate_ef7fd01f833ba1bcd449db9b9ffbff70cbb07e0666aaec1cc6fa6ad924b67a6c extends Twig_Template
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
\t<title>MADURA.BZ &mdash; DATA ";
        // line 5
        if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_type_), "html", null, true);
        echo "</title>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t
\t";
        // line 9
        $this->env->loadTemplate("pre-page.html")->display($context);
        // line 10
        echo "
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
\t
\t<div class=\"row\">
\t\t<div class=\"col-md-4\">
\t\t\t<h5 class=\"text-muted\" style=\"letter-spacing: 5px;\">
\t\t\t\t<i class=\"fa fa-newspaper-o\"></i> ";
        // line 23
        if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_type_), "html", null, true);
        echo "
\t\t\t</h5>
\t\t</div>
\t\t<div class=\"col-md-8\">
\t\t\t<form class=\"form-inline pull-right\" action=\"/";
        // line 27
        if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
        echo twig_escape_filter($this->env, $_type_, "html", null, true);
        echo "\">
\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t<label for=\"query\" class=\"sr-only\">Pencarian</label>
\t\t\t\t\t<input type=\"text\" name=\"query\" id=\"query\" class=\"form-control\" value=\"";
        // line 30
        if (isset($context["param"])) { $_param_ = $context["param"]; } else { $_param_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_param_, "query", array()), "html", null, true);
        echo "\" style=\"width: 200px;\">
\t\t\t\t\t<button class=\"btn btn-default\"><i class=\"fa fa-search\"></i> CARI</button>
\t\t\t\t</div>
\t\t\t</form>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t<div class=\"col-md-12\">
\t\t<div class=\"panel panel-default\">
\t\t\t<div class=\"panel-body\">
\t\t\t\t<br>
\t\t\t\t";
        // line 41
        if (isset($context["data"])) { $_data_ = $context["data"]; } else { $_data_ = null; }
        if ($_data_) {
            // line 42
            echo "\t\t\t\t<div class=\"table-responsive\">
\t\t\t\t\t<table class=\"table table-condensed table-hover\">
\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t";
            // line 45
            if (isset($context["data"])) { $_data_ = $context["data"]; } else { $_data_ = null; }
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($_data_);
            foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
                // line 46
                echo "\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t<td><a href=\"";
                // line 47
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
                echo "\"><img src=\"";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
                echo "\" alt=\"\" class=\"dirsearch-img\"></a></td>
\t\t\t\t\t\t\t\t<td style=\"width: 30%\">
\t\t\t\t\t\t\t\t\t<a href=\"";
                // line 49
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
                echo "\" style=\"font-size: 1.2em;\">";
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "judul", array()), "html", null, true);
                echo "</a><br>
\t\t\t\t\t\t\t\t\t<small class=\"text-muted\"><i class=\"fa fa-calendar\"></i> ";
                // line 50
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "tanggal", array()), "html", null, true);
                echo "</small>
\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t<td><p>";
                // line 52
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "isi", array()), "html", null, true);
                echo "</p></td>
\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 55
            echo "\t\t\t\t\t\t</tbody>
\t\t\t\t\t</table>
\t\t\t\t</div>
\t\t\t\t";
        } else {
            // line 59
            echo "\t\t\t\t<div class=\"well well-sm text-center\">
\t\t\t\t\t<h5 class=\"text-info\"><i class=\"fa fa-file-o\"></i> Tidak Ada Hasil</h5>
\t\t\t\t</div>
\t\t\t\t";
        }
        // line 63
        echo "\t\t\t</div>
\t\t\t<div class=\"panel-footer text-center\">
\t\t\t\t";
        // line 65
        if (isset($context["data"])) { $_data_ = $context["data"]; } else { $_data_ = null; }
        if ($_data_) {
            // line 66
            echo "\t\t\t\t<ul class=\"pagination pagination-sm\" style=\"margin: 10px 0;\">
\t\t\t\t\t<li";
            // line 67
            if (isset($context["cpage"])) { $_cpage_ = $context["cpage"]; } else { $_cpage_ = null; }
            if (($_cpage_ == 0)) {
                echo " class=\"disabled\"";
            }
            echo "><a href=\"/";
            if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
            echo twig_escape_filter($this->env, $_type_, "html", null, true);
            echo "?";
            if (isset($context["link"])) { $_link_ = $context["link"]; } else { $_link_ = null; }
            echo twig_escape_filter($this->env, $_link_, "html", null, true);
            echo "&cpage=0\">&laquo;</a></li>
\t\t\t\t\t";
            // line 68
            if (isset($context["numpage"])) { $_numpage_ = $context["numpage"]; } else { $_numpage_ = null; }
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable(range(0, ($_numpage_ - 1)));
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
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 69
                echo "\t\t\t\t\t<li";
                if (isset($context["cpage"])) { $_cpage_ = $context["cpage"]; } else { $_cpage_ = null; }
                if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
                if (($_cpage_ == $this->getAttribute($_loop_, "index0", array()))) {
                    echo " class=\"active\"";
                }
                echo "><a href=\"/";
                if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
                echo twig_escape_filter($this->env, $_type_, "html", null, true);
                echo "?";
                if (isset($context["link"])) { $_link_ = $context["link"]; } else { $_link_ = null; }
                echo twig_escape_filter($this->env, $_link_, "html", null, true);
                echo "&cpage=";
                if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index0", array()), "html", null, true);
                echo "\">";
                if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index", array()), "html", null, true);
                echo " <span class=\"sr-only\">(current)</span></a></li>
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 71
            echo "\t\t\t\t\t<li";
            if (isset($context["cpage"])) { $_cpage_ = $context["cpage"]; } else { $_cpage_ = null; }
            if (isset($context["numpage"])) { $_numpage_ = $context["numpage"]; } else { $_numpage_ = null; }
            if (($_cpage_ == ($_numpage_ - 1))) {
                echo " class=\"disabled\"";
            }
            echo "><a href=\"/";
            if (isset($context["type"])) { $_type_ = $context["type"]; } else { $_type_ = null; }
            echo twig_escape_filter($this->env, $_type_, "html", null, true);
            echo "?";
            if (isset($context["link"])) { $_link_ = $context["link"]; } else { $_link_ = null; }
            echo twig_escape_filter($this->env, $_link_, "html", null, true);
            echo "&cpage=";
            if (isset($context["numpage"])) { $_numpage_ = $context["numpage"]; } else { $_numpage_ = null; }
            echo twig_escape_filter($this->env, ($_numpage_ - 1), "html", null, true);
            echo "\">&raquo;</a></li>
\t\t\t\t</ul>
\t\t\t\t";
        }
        // line 74
        echo "\t\t\t</div>
\t\t</div>
\t</div>
\t
\t<hr class=\"main\">
\t
\t";
        // line 80
        $this->env->loadTemplate("footer.html")->display($context);
        // line 81
        echo "
</div>

";
        // line 84
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 85
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "berita-search.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  255 => 85,  253 => 84,  248 => 81,  246 => 80,  238 => 74,  218 => 71,  185 => 69,  167 => 68,  154 => 67,  151 => 66,  148 => 65,  144 => 63,  138 => 59,  132 => 55,  122 => 52,  116 => 50,  108 => 49,  99 => 47,  96 => 46,  91 => 45,  86 => 42,  83 => 41,  68 => 30,  61 => 27,  53 => 23,  45 => 17,  43 => 16,  35 => 10,  33 => 9,  25 => 5,  19 => 1,);
    }
}
