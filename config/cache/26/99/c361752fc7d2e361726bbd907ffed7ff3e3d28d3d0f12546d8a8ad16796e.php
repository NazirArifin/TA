<?php

/* produk.html */
class __TwigTemplate_2699c361752fc7d2e361726bbd907ffed7ff3e3d28d3d0f12546d8a8ad16796e extends Twig_Template
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
        if (isset($context["nama"])) { $_nama_ = $context["nama"]; } else { $_nama_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_nama_), "html", null, true);
        echo "</title>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t
\t";
        // line 9
        $this->env->loadTemplate("pre-page.html")->display($context);
        // line 10
        echo "
";
        // line 11
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        if (($_direktori_ != "Semua Produk")) {
            // line 12
            echo "<script>
\twindow.produk = '";
            // line 13
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "';
\twindow.member = '";
            // line 14
            if (isset($context["member_kode"])) { $_member_kode_ = $context["member_kode"]; } else { $_member_kode_ = null; }
            echo twig_escape_filter($this->env, $_member_kode_, "html", null, true);
            echo "';
</script>
";
        }
        // line 17
        echo "\t
</head>
<body>
<div class=\"container\">
\t
\t";
        // line 22
        $this->env->loadTemplate("header.html")->display($context);
        // line 23
        echo "\t
\t<hr class=\"header\">
\t<div class=\"col-md-12\">
\t\t<div class=\"panel panel-default\">
\t\t\t<div class=\"panel-body\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t<h5>
\t\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-code fa-stack-1x fa-inverse\"></i></span>
\t\t\t\t\t\t";
        // line 31
        if (isset($context["nama"])) { $_nama_ = $context["nama"]; } else { $_nama_ = null; }
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, $_nama_), "html", null, true);
        echo " 
\t\t\t\t\t\t";
        // line 32
        if (isset($context["stok"])) { $_stok_ = $context["stok"]; } else { $_stok_ = null; }
        if ($_stok_) {
            echo "<sup class=\"label label-success\"><small style=\"color: #fff\">TERSEDIA</small></sup>";
        }
        // line 33
        echo "\t\t\t\t\t\t";
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        if (isset($context["stok"])) { $_stok_ = $context["stok"]; } else { $_stok_ = null; }
        if ((($_direktori_ == "Semua Produk") && ($_stok_ == 0))) {
            echo "<sup class=\"label label-danger\"><small style=\"color: #fff\">TERJUAL</small></sup>";
        }
        // line 34
        echo "\t\t\t\t\t\t<small class=\"btn-group pull-right\">
\t\t\t\t\t\t\t<a href=\"\" class=\"btn btn-default\"><i class=\"fa fa-download\"></i> Katalog</a>
\t\t\t\t\t\t\t<a href=\"";
        // line 36
        if (isset($context["direktori_link"])) { $_direktori_link_ = $context["direktori_link"]; } else { $_direktori_link_ = null; }
        echo twig_escape_filter($this->env, $_direktori_link_, "html", null, true);
        echo "\" class=\"btn btn-warning\"><i class=\"fa ";
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        if (($_direktori_ == "Semua Produk")) {
            echo "fa-search";
        } else {
            echo "fa-home";
        }
        echo "\"></i> ";
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        echo twig_escape_filter($this->env, $_direktori_, "html", null, true);
        echo "</a>
\t\t\t\t\t\t</small>
\t\t\t\t\t</h5><hr class=\"main\">
\t\t\t\t\t<div class=\"pull-left col-md-3\">
\t\t\t\t\t\t<img src=\"";
        // line 40
        if (isset($context["foto"])) { $_foto_ = $context["foto"]; } else { $_foto_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_foto_, 0, array(), "array"), "html", null, true);
        echo "\" alt=\"\" class=\"img-responsive zoomable-gallery\" data-zoom-image=\"";
        if (isset($context["foto"])) { $_foto_ = $context["foto"]; } else { $_foto_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_foto_, 0, array(), "array"), "html", null, true);
        echo "\">
\t\t\t\t\t\t<div style=\"margin-top: 10px;\" class=\"well well-sm text-center\">
\t\t\t\t\t\t\t<h5><strong class=\"text-success\">Rp. ";
        // line 42
        if (isset($context["harga"])) { $_harga_ = $context["harga"]; } else { $_harga_ = null; }
        echo twig_escape_filter($this->env, $_harga_, "html", null, true);
        echo ",-</strong></h5>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-7\">
\t\t\t\t\t\t";
        // line 47
        echo "\t\t\t\t\t\t<div style=\"line-height: 1.3em;\">
\t\t\t\t\t\t\t<strong class=\"text-muted\"><i class=\"fa fa-tags\"></i> ";
        // line 48
        if (isset($context["kategori"])) { $_kategori_ = $context["kategori"]; } else { $_kategori_ = null; }
        echo $_kategori_;
        echo "</strong>
\t\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t\t<div class=\"well well-sm\">
\t\t\t\t\t\t\t";
        // line 51
        if (isset($context["info"])) { $_info_ = $context["info"]; } else { $_info_ = null; }
        echo $_info_;
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
        // line 53
        if (isset($context["stok"])) { $_stok_ = $context["stok"]; } else { $_stok_ = null; }
        if ($_stok_) {
            // line 54
            echo "\t\t\t\t\t\t\t<button class=\"btn btn-primary pull-right\" data-ng-click=\"addItem(";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo $this->getAttribute($_c_, "id", array());
            echo ")\" data-ng-hide=\"itemTaken(";
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo $this->getAttribute($_c_, "id", array());
            echo ")\">TAMBAH KE KERANJANG <i class=\"fa fa-cart-plus\"></i></button>
\t\t\t\t\t\t\t";
        }
        // line 56
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
        // line 58
        echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-2\">
\t\t\t\t\t\t<div class=\"well\">&nbsp;</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"clearfix\"></div>
\t\t\t\t<ul id=\"gallery\" class=\"clearfix\">
\t\t\t\t\t";
        // line 65
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
            // line 66
            echo "\t\t\t\t\t<li id=\"0";
            if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index", array()), "html", null, true);
            echo "\" class=\"col-md-2 col-sm-3 col-xs-6\">
\t\t\t\t\t\t<a href=\"\" data-zoom-image=\"";
            // line 67
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
        // line 70
        echo "\t\t\t\t</ul>
\t\t\t\t<hr class=\"main\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t";
        // line 73
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        if (($_direktori_ != "Semua Produk")) {
            // line 74
            echo "\t\t\t\t\t<h5>
\t\t\t\t\t\t<span class=\"fa-stack\"><i class=\"fa fa-square fa-stack-2x\"></i><i class=\"fa fa-binoculars fa-stack-1x fa-inverse\"></i></span>
\t\t\t\t\t\tREVIEW PRODUK
\t\t\t\t\t</h5>
\t\t\t\t\t<div class=\"col-md-8\" data-ng-controller=\"ProdukCtrl\" data-ng-cloak>
\t\t\t\t\t\t<div class=\"well\" data-ng-hide=\"reviewList\">
\t\t\t\t\t\t\t<h3 class=\"text-center text-info\"><i class=\"fa fa-file-o\"></i> Belum ada Review</h3>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t\t\t";
            // line 108
            echo "
\t\t\t\t\t\t<div data-ng-show=\"reviewList\" data-ng-repeat=\"c in reviewList\" data-ng-show=\"c.lihat\">
\t\t\t\t\t\t\t<div class=\"media\" style=\"padding-bottom: 5px;\">
\t\t\t\t\t\t\t\t<a data-ng-href=\"{{c.link}}\" class=\"pull-left\">
\t\t\t\t\t\t\t\t\t<img data-ng-src=\"{{c.foto}}\" alt=\"\" class=\"post-image\">
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<div class=\"media-body full-width\">
\t\t\t\t\t\t\t\t\t<h4 class=\"media-heading\">
\t\t\t\t\t\t\t\t\t\t<a data-ng-href=\"{{c.link}}\"><span data-ng-show=\"c.valid\"><i class=\"fa fa-check-circle\"></i> </span>{{c.nama}}</a>
\t\t\t\t\t\t\t\t\t\t<small class=\"text-muted pull-right\"><i class=\"fa fa-clock-o\"></i> {{c.tanggal}}</small>
\t\t\t\t\t\t\t\t\t</h4>
\t\t\t\t\t\t\t\t\t<p style=\"margin-bottom: 10px\">
\t\t\t\t\t\t\t\t\t\t<span data-ng-bind-html=\"c.isi\">{{c.isi}}</span>
\t\t\t\t\t\t\t\t\t\t<span>
\t\t\t\t\t\t\t\t\t\t\t<br><br>
\t\t\t\t\t\t\t\t\t\t\t<span class=\"btn-group pull-right\">
\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"\" class=\"btn btn-primary btn-xs\" data-ng-show=\"c.setuju\" data-ng-click=\"setStatus(c.id, 2)\"><i class=\"fa fa-check-square\"></i> Tampil</a>
\t\t\t\t\t\t\t\t\t\t\t\t<a href=\"\" class=\"btn btn-warning btn-xs\" delete-data=\"{{c.id}}\" data-type=\"review\" data-ng-show=\"c.hapus\"><i class=\"fa fa-trash-o\"></i> Hapus</a>
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<hr class=\"main\" data-ng-show=\"\$index < reviewList.length - 1\">
\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            echo "
\t\t\t\t\t\t
\t\t\t\t\t\t";
            // line 110
            if (isset($context["member_direktori"])) { $_member_direktori_ = $context["member_direktori"]; } else { $_member_direktori_ = null; }
            if (isset($context["direktori_id"])) { $_direktori_id_ = $context["direktori_id"]; } else { $_direktori_id_ = null; }
            if (isset($context["member_valid"])) { $_member_valid_ = $context["member_valid"]; } else { $_member_valid_ = null; }
            if ((($_member_direktori_ != $_direktori_id_) && $_member_valid_)) {
                // line 111
                echo "\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<hr class=\"main\">
\t\t\t\t\t\t\t<form>
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<textarea name=\"\" id=\"\" cols=\"30\" rows=\"8\" class=\"form-control\" placeholder=\"Anda dapat menambahkan review Anda disini\" data-ng-model=\"review\"></textarea>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"clearfix\">
\t\t\t\t\t\t\t\t\t<button class=\"btn btn-success pull-right\" save-review><i class=\"fa fa-check\"></i> Tambahkan Review</button>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            }
            // line 123
            echo "\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t";
        }
        // line 126
        echo "\t\t\t\t\t<div class=\"";
        if (isset($context["direktori"])) { $_direktori_ = $context["direktori"]; } else { $_direktori_ = null; }
        if (($_direktori_ == "Semua Produk")) {
            echo "col-md-10 col-md-offset-1";
        } else {
            echo "col-md-4";
        }
        echo "\">
\t\t\t\t\t\t<ul class=\"widget-products\">
\t\t\t\t\t\t\t";
        // line 128
        if (isset($context["other"])) { $_other_ = $context["other"]; } else { $_other_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_other_);
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 129
            echo "\t\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t\t<a href=\"";
            // line 130
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "link", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t\t<span class=\"img\"><img src=\"";
            // line 131
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "foto", array()), "html", null, true);
            echo "\" alt=\"\"></span>
\t\t\t\t\t\t\t\t\t<span class=\"product clearfix\">
\t\t\t\t\t\t\t\t\t\t<span class=\"name\">";
            // line 133
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "nama", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t<span class=\"price text-success\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-money\"></i> Rp. ";
            // line 135
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_c_, "harga", array()), "html", null, true);
            echo ",-
\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t";
            // line 137
            if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
            if ($this->getAttribute($_c_, "info", array())) {
                // line 138
                echo "\t\t\t\t\t\t\t\t\t\t<strong class=\"warranty text-muted\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-info-circle\"></i> ";
                // line 139
                if (isset($context["c"])) { $_c_ = $context["c"]; } else { $_c_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_c_, "info", array()), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t\t\t</strong>
\t\t\t\t\t\t\t\t\t\t";
            }
            // line 142
            echo "\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 146
        echo "\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<hr class=\"main\">
\t
\t";
        // line 154
        $this->env->loadTemplate("footer.html")->display($context);
        // line 155
        echo "\t
</div>

";
        // line 158
        $this->env->loadTemplate("post-page.html")->display($context);
        // line 159
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "produk.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  376 => 159,  374 => 158,  369 => 155,  367 => 154,  357 => 146,  348 => 142,  341 => 139,  338 => 138,  335 => 137,  329 => 135,  323 => 133,  317 => 131,  312 => 130,  309 => 129,  304 => 128,  293 => 126,  288 => 123,  274 => 111,  269 => 110,  239 => 108,  228 => 74,  225 => 73,  220 => 70,  196 => 67,  190 => 66,  172 => 65,  163 => 58,  160 => 56,  150 => 54,  147 => 53,  141 => 51,  134 => 48,  131 => 47,  123 => 42,  114 => 40,  96 => 36,  92 => 34,  85 => 33,  80 => 32,  75 => 31,  65 => 23,  63 => 22,  56 => 17,  49 => 14,  44 => 13,  41 => 12,  38 => 11,  35 => 10,  33 => 9,  25 => 5,  19 => 1,);
    }
}
