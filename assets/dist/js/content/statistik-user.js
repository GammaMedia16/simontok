am4core.useTheme(am4themes_amcharts);

//GRAFIK PKS PER TAHUN
var chartPKSTahun = am4core.create("chartPKSTahun", am4charts.XYChart3D);

chartPKSTahun.data = dataPKSTahun;
chartPKSTahun.padding(10);

var categoryAxisPKSTahun = chartPKSTahun.xAxes.push(new am4charts.CategoryAxis());
categoryAxisPKSTahun.renderer.grid.template.location = 0;
categoryAxisPKSTahun.dataFields.category = "tahun";
categoryAxisPKSTahun.renderer.minGridDistance = 20;
categoryAxisPKSTahun.title.text = "Tahun";
categoryAxisPKSTahun.title.fontWeight = "bold";



var valueAxisPKSTahun = chartPKSTahun.yAxes.push(new am4charts.ValueAxis());
valueAxisPKSTahun.title.text = "Jumlah";
valueAxisPKSTahun.title.fontWeight = "bold";

var seriesPKSTahun = chartPKSTahun.series.push(new am4charts.ColumnSeries3D());
seriesPKSTahun.dataFields.categoryX = "tahun";
seriesPKSTahun.dataFields.valueY = "value";
seriesPKSTahun.tooltipText = "Tahun {categoryX} : {valueY.value}";
seriesPKSTahun.columns.template.strokeOpacity = 0;
seriesPKSTahun.tooltip.exportable = true

var valueLabelPKSTahun = seriesPKSTahun.bullets.push(new am4charts.LabelBullet());
valueLabelPKSTahun.label.text = "{value}";
valueLabelPKSTahun.label.fontSize = 11;
valueLabelPKSTahun.label.fontWeight = "bold";
valueLabelPKSTahun.dy = 10;

chartPKSTahun.cursor = new am4charts.XYCursor();
chartPKSTahun.numberFormatter.numberFormat = "#.###,#####";
chartPKSTahun.exporting.menu = new am4core.ExportMenu();
chartPKSTahun.exporting.filePrefix = "grafik_jumlah_data_pks_per_tahun";
chartPKSTahun.exporting.menu.items = [
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
chartPKSTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titlePKSTahun = chartPKSTahun.titles.create();
titlePKSTahun.text = "Grafik Jumlah PKS Kemitraan Konservasi per Tahun";
titlePKSTahun.fontSize = 16;
titlePKSTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesPKSTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartPKSTahun.colors.getIndex(target.dataItem.index);
});

//GRAFIK LUAS PKS PER TAHUN
var chartLuasPKSTahun = am4core.create("chartLuasPKSTahun", am4charts.XYChart);

chartLuasPKSTahun.data = dataLuasPKSTahun;
chartLuasPKSTahun.padding(10);

var categoryAxisLuasPKSTahun = chartLuasPKSTahun.yAxes.push(new am4charts.CategoryAxis());
categoryAxisLuasPKSTahun.renderer.grid.template.location = 0;
categoryAxisLuasPKSTahun.dataFields.category = "tahun";
categoryAxisLuasPKSTahun.renderer.minGridDistance = 20;
categoryAxisLuasPKSTahun.title.text = "Tahun";
categoryAxisLuasPKSTahun.title.fontWeight = "bold";
categoryAxisLuasPKSTahun.renderer.inversed = true;



var valueAxisLuasPKSTahun = chartLuasPKSTahun.xAxes.push(new am4charts.ValueAxis());
valueAxisLuasPKSTahun.title.text = "Luas (Ha)";
valueAxisLuasPKSTahun.title.fontWeight = "bold";
valueAxisLuasPKSTahun.numberFormatter.numberFormat = "#,###";


var seriesLuasPKSTahun = chartLuasPKSTahun.series.push(new am4charts.ColumnSeries());
seriesLuasPKSTahun.dataFields.categoryY = "tahun";
seriesLuasPKSTahun.dataFields.valueX = "value";
seriesLuasPKSTahun.tooltipText = "Tahun {categoryY} : {valueX.value.formatNumber('#,###.##')} Ha";
seriesLuasPKSTahun.columns.template.strokeOpacity = 0;
seriesLuasPKSTahun.tooltip.exportable = true

var valueLabelLuasPKSTahun = seriesLuasPKSTahun.columns.template.createChild(am4core.Label);
valueLabelLuasPKSTahun.text = "{value.formatNumber('#,###.##')} Ha";
valueLabelLuasPKSTahun.fontSize = 14;
valueLabelLuasPKSTahun.fontWeight = "bold";
valueLabelLuasPKSTahun.valign = "middle";
valueLabelLuasPKSTahun.dx = 10;
valueLabelLuasPKSTahun.strokeWidth = 0;




chartLuasPKSTahun.cursor = new am4charts.XYCursor();
chartLuasPKSTahun.numberFormatter.numberFormat = "#.###,#####";
chartLuasPKSTahun.exporting.menu = new am4core.ExportMenu();
chartLuasPKSTahun.exporting.filePrefix = "grafik_jumlah_data_luas_pks_per_tahun";
chartLuasPKSTahun.exporting.menu.items = [
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
chartLuasPKSTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleLuasPKSTahun = chartLuasPKSTahun.titles.create();
titleLuasPKSTahun.text = "Grafik Luas Kemitraan Konservasi per Tahun";
titleLuasPKSTahun.fontSize = 16;
titleLuasPKSTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesLuasPKSTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartLuasPKSTahun.colors.getIndex(target.dataItem.index);
});

