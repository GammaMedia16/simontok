am4core.useTheme(am4themes_amcharts);

//GRAFIK MASYARAKAT TERLIBAT PDSKK PER TAHUN
var chartMasyBinaDesaTahun = am4core.create("chartMasyBinaDesaTahun", am4charts.XYChart);

chartMasyBinaDesaTahun.data = dataMasyBinaDesaTahun;
chartMasyBinaDesaTahun.padding(10);

var categoryAxisMasyBinaDesaTahun = chartMasyBinaDesaTahun.yAxes.push(new am4charts.CategoryAxis());
categoryAxisMasyBinaDesaTahun.renderer.grid.template.location = 0;
categoryAxisMasyBinaDesaTahun.dataFields.category = "tahun";
categoryAxisMasyBinaDesaTahun.renderer.minGridDistance = 20;
categoryAxisMasyBinaDesaTahun.title.text = "Tahun";
categoryAxisMasyBinaDesaTahun.title.fontWeight = "bold";
categoryAxisMasyBinaDesaTahun.renderer.inversed = true;



var valueAxisMasyBinaDesaTahun = chartMasyBinaDesaTahun.xAxes.push(new am4charts.ValueAxis());
valueAxisMasyBinaDesaTahun.title.text = "Jumlah (Orang)";
valueAxisMasyBinaDesaTahun.title.fontWeight = "bold";
valueAxisMasyBinaDesaTahun.numberFormatter.numberFormat = "#,###";


var seriesMasyBinaDesaTahun = chartMasyBinaDesaTahun.series.push(new am4charts.ColumnSeries());
seriesMasyBinaDesaTahun.dataFields.categoryY = "tahun";
seriesMasyBinaDesaTahun.dataFields.valueX = "value";
seriesMasyBinaDesaTahun.tooltipText = "Tahun {categoryY} : {valueX.value.formatNumber('#,###')} Orang";
seriesMasyBinaDesaTahun.columns.template.strokeOpacity = 0;
seriesMasyBinaDesaTahun.tooltip.exportable = true

var valueLabelMasyBinaDesaTahun = seriesMasyBinaDesaTahun.columns.template.createChild(am4core.Label);
valueLabelMasyBinaDesaTahun.text = "{value.formatNumber('#,###.##')} Orang";
valueLabelMasyBinaDesaTahun.fontSize = 14;
valueLabelMasyBinaDesaTahun.fontWeight = "bold";
valueLabelMasyBinaDesaTahun.valign = "middle";
valueLabelMasyBinaDesaTahun.dx = 10;
valueLabelMasyBinaDesaTahun.strokeWidth = 0;




chartMasyBinaDesaTahun.cursor = new am4charts.XYCursor();
chartMasyBinaDesaTahun.numberFormatter.numberFormat = "#.###,#####";
chartMasyBinaDesaTahun.exporting.menu = new am4core.ExportMenu();
chartMasyBinaDesaTahun.exporting.filePrefix = "grafik_jumlah_data_masyarakat_terlibat_binadesa_per_tahun";
chartMasyBinaDesaTahun.exporting.menu.items = [
  {
    "label": "...",
    "menu": [
      {
        "label": "Image",
        "menu": [
          { "type": "png", "label": "PNG" },
          { "type": "jpg", "label": "JPG" },
          { "type": "pdf", "label": "PDF" }
        ]
      }, {
        "label": "Print", "type": "print"
      }
    ]
  }
];
chartMasyBinaDesaTahun.colors.list = [
  am4core.color("#bec4f8"),
  am4core.color("#a5abee"),
  am4core.color("#6a6dde"),
  am4core.color("#4d42cf"),
  am4core.color("#713e8d"),
  am4core.color("#a160a0")
];
// Add chart title
var titleMasyBinaDesaTahun = chartMasyBinaDesaTahun.titles.create();
titleMasyBinaDesaTahun.text = "Grafik Jumlah Masyarakat Terlibat Pembinaan Desa";
titleMasyBinaDesaTahun.fontSize = 16;
titleMasyBinaDesaTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesMasyBinaDesaTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartMasyBinaDesaTahun.colors.getIndex(target.dataItem.index);
});

//GRAFIK KELOMPOK TERLIBAT PER TAHUN
var chartKelompokBinaDesaTahunn = am4core.create("chartKelompokBinaDesaTahun", am4charts.XYChart3D);

chartKelompokBinaDesaTahunn.data = dataKelompokBinaDesaTahun;
chartKelompokBinaDesaTahunn.padding(10);

var categoryAxisKelompokBinaDesaTahunn = chartKelompokBinaDesaTahunn.xAxes.push(new am4charts.CategoryAxis());
categoryAxisKelompokBinaDesaTahunn.renderer.grid.template.location = 0;
categoryAxisKelompokBinaDesaTahunn.dataFields.category = "tahun";
categoryAxisKelompokBinaDesaTahunn.renderer.minGridDistance = 20;
categoryAxisKelompokBinaDesaTahunn.title.text = "Tahun";
categoryAxisKelompokBinaDesaTahunn.title.fontWeight = "bold";



var valueAxisKelompokBinaDesaTahunn = chartKelompokBinaDesaTahunn.yAxes.push(new am4charts.ValueAxis());
valueAxisKelompokBinaDesaTahunn.title.text = "Jumlah";
valueAxisKelompokBinaDesaTahunn.title.fontWeight = "bold";

var seriesKelompokBinaDesaTahunn = chartKelompokBinaDesaTahunn.series.push(new am4charts.ColumnSeries3D());
seriesKelompokBinaDesaTahunn.dataFields.categoryX = "tahun";
seriesKelompokBinaDesaTahunn.dataFields.valueY = "value";
seriesKelompokBinaDesaTahunn.tooltipText = "Tahun {categoryX} : {valueY.value}";
seriesKelompokBinaDesaTahunn.columns.template.strokeOpacity = 0;
seriesKelompokBinaDesaTahunn.tooltip.exportable = true

var valueLabelKelompokBinaDesaTahunn = seriesKelompokBinaDesaTahunn.bullets.push(new am4charts.LabelBullet());
valueLabelKelompokBinaDesaTahunn.label.text = "{value}";
valueLabelKelompokBinaDesaTahunn.label.fontSize = 11;
valueLabelKelompokBinaDesaTahunn.label.fontWeight = "bold";
valueLabelKelompokBinaDesaTahunn.dy = 10;

chartKelompokBinaDesaTahunn.cursor = new am4charts.XYCursor();
chartKelompokBinaDesaTahunn.numberFormatter.numberFormat = "#.###,#####";
chartKelompokBinaDesaTahunn.exporting.menu = new am4core.ExportMenu();
chartKelompokBinaDesaTahunn.exporting.filePrefix = "grafik_jumlah_data_kelompok_terlibat_pdskk_per_tahun";
chartKelompokBinaDesaTahunn.exporting.menu.items = [
  {
    "label": "...",
    "menu": [
      {
        "label": "Image",
        "menu": [
          { "type": "png", "label": "PNG" },
          { "type": "jpg", "label": "JPG" },
          { "type": "pdf", "label": "PDF" }
        ]
      }, {
        "label": "Print", "type": "print"
      }
    ]
  }
];
chartKelompokBinaDesaTahunn.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleKelompokBinaDesaTahunn = chartKelompokBinaDesaTahunn.titles.create();
titleKelompokBinaDesaTahunn.text = "Grafik Jumlah Kelompok Terlibat Pembinaan Desa";
titleKelompokBinaDesaTahunn.fontSize = 16;
titleKelompokBinaDesaTahunn.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesKelompokBinaDesaTahunn.columns.template.adapter.add("fill", function (fill, target) {
    return chartKelompokBinaDesaTahunn.colors.getIndex(target.dataItem.index);
});

//GRAFIK DESA TERLIBAT PER TAHUN 
var chartDesaTerlibatTahun = am4core.create("chartDesaTerlibatTahun", am4charts.XYChart3D);

chartDesaTerlibatTahun.data = dataDesaTerlibatTahun;
chartDesaTerlibatTahun.padding(10);

var categoryAxisDesaTerlibatTahun = chartDesaTerlibatTahun.xAxes.push(new am4charts.CategoryAxis());
categoryAxisDesaTerlibatTahun.renderer.grid.template.location = 0;
categoryAxisDesaTerlibatTahun.dataFields.category = "tahun";
categoryAxisDesaTerlibatTahun.renderer.minGridDistance = 20;
categoryAxisDesaTerlibatTahun.title.text = "Tahun";
categoryAxisDesaTerlibatTahun.title.fontWeight = "bold";



var valueAxisDesaTerlibatTahun = chartDesaTerlibatTahun.yAxes.push(new am4charts.ValueAxis());
valueAxisDesaTerlibatTahun.title.text = "Jumlah";
valueAxisDesaTerlibatTahun.title.fontWeight = "bold";

var seriesDesaTerlibatTahun = chartDesaTerlibatTahun.series.push(new am4charts.ColumnSeries3D());
seriesDesaTerlibatTahun.dataFields.categoryX = "tahun";
seriesDesaTerlibatTahun.dataFields.valueY = "value";
seriesDesaTerlibatTahun.tooltipText = "Tahun {categoryX} : {valueY.value}";
seriesDesaTerlibatTahun.columns.template.strokeOpacity = 0;
seriesDesaTerlibatTahun.tooltip.exportable = true

var valueLabelDesaTerlibatTahun = seriesDesaTerlibatTahun.bullets.push(new am4charts.LabelBullet());
valueLabelDesaTerlibatTahun.label.text = "{value}";
valueLabelDesaTerlibatTahun.label.fontSize = 11;
valueLabelDesaTerlibatTahun.label.fontWeight = "bold";
valueLabelDesaTerlibatTahun.dy = 10;

chartDesaTerlibatTahun.cursor = new am4charts.XYCursor();
chartDesaTerlibatTahun.numberFormatter.numberFormat = "#.###,#####";
chartDesaTerlibatTahun.exporting.menu = new am4core.ExportMenu();
chartDesaTerlibatTahun.exporting.filePrefix = "grafik_jumlah_data_desa_terlibat_pdskk_per_tahun";
chartDesaTerlibatTahun.exporting.menu.items = [
  {
    "label": "...",
    "menu": [
      {
        "label": "Image",
        "menu": [
          { "type": "png", "label": "PNG" },
          { "type": "jpg", "label": "JPG" },
          { "type": "pdf", "label": "PDF" }
        ]
      }, {
        "label": "Print", "type": "print"
      }
    ]
  }
];
chartDesaTerlibatTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleDesaTerlibatTahun = chartDesaTerlibatTahun.titles.create();
titleDesaTerlibatTahun.text = "Grafik Jumlah Desa Terlibat Pembinaan Desa";
titleDesaTerlibatTahun.fontSize = 16;
titleDesaTerlibatTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesDesaTerlibatTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartDesaTerlibatTahun.colors.getIndex(target.dataItem.index);
});



//GRAFIK SATKER TERLIBAT PER TAHUN 
var chartSatkerTerlibatTahun = am4core.create("chartSatkerTerlibatTahun", am4charts.XYChart3D);

chartSatkerTerlibatTahun.data = dataSatkerTerlibatTahun;
chartSatkerTerlibatTahun.padding(10);

var categoryAxisSatkerTerlibatTahun = chartSatkerTerlibatTahun.xAxes.push(new am4charts.CategoryAxis());
categoryAxisSatkerTerlibatTahun.renderer.grid.template.location = 0;
categoryAxisSatkerTerlibatTahun.dataFields.category = "tahun";
categoryAxisSatkerTerlibatTahun.renderer.minGridDistance = 20;
categoryAxisSatkerTerlibatTahun.title.text = "Tahun";
categoryAxisSatkerTerlibatTahun.title.fontWeight = "bold";



var valueAxisSatkerTerlibatTahun = chartSatkerTerlibatTahun.yAxes.push(new am4charts.ValueAxis());
valueAxisSatkerTerlibatTahun.title.text = "Jumlah";
valueAxisSatkerTerlibatTahun.title.fontWeight = "bold";

var seriesSatkerTerlibatTahun = chartSatkerTerlibatTahun.series.push(new am4charts.ColumnSeries3D());
seriesSatkerTerlibatTahun.dataFields.categoryX = "tahun";
seriesSatkerTerlibatTahun.dataFields.valueY = "value";
seriesSatkerTerlibatTahun.tooltipText = "Tahun {categoryX} : {valueY.value}";
seriesSatkerTerlibatTahun.columns.template.strokeOpacity = 0;
seriesSatkerTerlibatTahun.tooltip.exportable = true

var valueLabelSatkerTerlibatTahun = seriesSatkerTerlibatTahun.bullets.push(new am4charts.LabelBullet());
valueLabelSatkerTerlibatTahun.label.text = "{value}";
valueLabelSatkerTerlibatTahun.label.fontSize = 11;
valueLabelSatkerTerlibatTahun.label.fontWeight = "bold";
valueLabelSatkerTerlibatTahun.dy = 10;

chartSatkerTerlibatTahun.cursor = new am4charts.XYCursor();
chartSatkerTerlibatTahun.numberFormatter.numberFormat = "#.###,#####";
chartSatkerTerlibatTahun.exporting.menu = new am4core.ExportMenu();
chartSatkerTerlibatTahun.exporting.filePrefix = "grafik_jumlah_data_satker_terlibat_pdskk_per_tahun";
chartSatkerTerlibatTahun.exporting.menu.items = [
  {
    "label": "...",
    "menu": [
      {
        "label": "Image",
        "menu": [
          { "type": "png", "label": "PNG" },
          { "type": "jpg", "label": "JPG" },
          { "type": "pdf", "label": "PDF" }
        ]
      }, {
        "label": "Print", "type": "print"
      }
    ]
  }
];
chartSatkerTerlibatTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleSatkerTerlibatTahun = chartSatkerTerlibatTahun.titles.create();
titleSatkerTerlibatTahun.text = "Grafik Jumlah Satuan Kerja Terlibat Pembinaan Desa";
titleSatkerTerlibatTahun.fontSize = 16;
titleSatkerTerlibatTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesSatkerTerlibatTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartSatkerTerlibatTahun.colors.getIndex(target.dataItem.index);
});
