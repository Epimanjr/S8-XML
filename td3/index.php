<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>TP3 - XPath, PHP et flux RSS</title>
    </head>
    <body>
        <?php
        // Question 1 : Choix d'un blog sur over-blog
        //$blog = 'http://www.earth-of-fire.com/';
        $blog = 'http://onvqf.over-blog.com/';

        // Question 2 : Récupère le code source d'un site.
        function get_html($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            return curl_exec($ch);
        }

        // Je n'arrive pas à faire fonctionner la méthode libxml_use_internal_errors();
        // Utilisation d'une alternative
        error_reporting(0);

        // Question 3 : Création de l'arbre DOM
        $doc = new DOMDocument();
        $doc->loadHTML(get_html($blog));
        //echo $doc->saveHTML();
        
        // Question 4 : Requête XPATH
        $xpath = new DOMXPath($doc);
        $articles = $xpath->query('//div[@class="article"]');
        
        // Nombre d'articles
        printf('%d articles trouvées : <br /><hr/>', $articles->length);

        // Liste des articles
        for ($i = 0; $i < ($articles->length); $i++) {
            $article = $articles->item($i);
            $url = $xpath->evaluate('string(.//a/@href)', $article);
            $nom = $xpath->evaluate('string(.//a/@title)', $article); 
            echo "Nom de l'article : $nom <br/>Lien : $url<br/><hr/>";
        }
        ?>
    </body>
</html>
