/******************* Camembert ******************/
function Camembert() {
    var chartData = [
        {title: "Ne souhaite pas répondre", value: 3},
        {title: "Inférieur à 20 000 €", value: 2},
        {title: "Entre 20 000 € et 25 000 €", value: 9},
        {title: "Entre 25 000 € et 30 000 €", value: 7},
        {title: "Entre 30 000 € et 35 000 €", value: 5},
        {title: "Entre 35 000 € et 40 000 €", value: 3},
        {title: "Entre 40 000 € et 45 000 €", value: 2},
        {title: "Supérieur à 45 000 €", value: 1}
    ];

    AmCharts.ready(function() {
        var pie = new AmCharts.AmPieChart();
        pie.valueField = "value";
        pie.titleField = "title";
        pie.dataProvider = chartData;

        // Design
        pie.outlineColor = "#FFFFFF"; // couleur du contour du camembert
        pie.outlineAlpha = 0.8;	// opacité du contour du camembert
        pie.outlineThickness = 2; // épaisseur du contour

        // Pour la 3D
        pie.depth3D = 15;
        pie.angle = 30;

        // J'affiche le camembert
        pie.write("camembert");
    });
}
Camembert();

/******************* Classique ********************/
function Classique() {
    var chartData = [
        {region: "Pyrénées Atlantiques", visits: 4252},
        {region: "Landes", visits: 1882},
        {region: "Gironde", visits: 1809},
        {region: "Lot-Et-Garonne", visits: 1322},
        {region: "Dordogne", visits: 1122},
        {region: "Lot", visits: 1114},
        {region: "Tarn", visits: 984},
        {region: "Ariège", visits: 711},
        {region: "Allier", visits: 665},
        {region: "Calvados", visits: 580},
        {region: "Loire", visits: 443},
        {region: "Savoie", visits: 441},
        {region: "Yonne", visits: 395},
        {region: "Somme", visits: 386},
        {region: "Pas de Calais", visits: 384},
        {region: "Jura", visits: 338},
        {region: "Vendée", visits: 999}
    ];

    /**
     * On commence par créer un objet AmSerialChart, on définit la source (dataProvider) et les catégories sur
     * l'axe x (categoryFiel). Ici on crée donc le tableau qui va contenir notre futur graphe.
     */
    AmCharts.ready(function() {
        var chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartData;
        chart.categoryField = "region";

        /**
         * Si à l'affichage les catégories sont coupés, il est possible de définir à la main les marges du tableau
         * grâce à des fonctions de types chart.marginTop = 15; etc
         */
        chart.marginTop = 60; //sinon la pub cache le haut gauche du graphe.

        // Pour faire de la fausse 3D, on contrôle la profondeur des colonnes et l'angle
        chart.angle = 30;
        chart.depth3D = 15;


        // Permet de faire une rotation de 90° des noms de catégories, évite ainsi les trucs illisibles.
        var catAxis = chart.categoryAxis;
        catAxis.gridCount = chartData.length;
        catAxis.labelRotation = 90;
        catAxis.forceShowField = "region"; // pour forcer l'affichage de toutes les catégories

        // Maintenant nous allons générer le graphe. On commence par créer un objet de type AmGraph().
        var graph = new AmCharts.AmGraph();

        // Ensuite on précise quelles valeurs seront représentées par les colonnes.
        graph.valueField = "visits";

        // On définit le type (par défaut c'est une courbe)
        graph.type = "column";

        // Pour la fausse 3D, on va gérer l'opacité (de 0 à 1) des contours puis du contenu.
        graph.lineAlpha = 0; // en gros je cache les contours et
        graph.fillAlphas = 1; // je remplis les colonnes

        // Je modifie le contenu des bulles, just for fun
        graph.balloonText = "[[category]]: [[value]]"; // balise prédéfinie

        // Pour finir nous ajoutons juste le graphe au tableau
        chart.addGraph(graph);
        chart.write("classique");
    });
}
Classique();
