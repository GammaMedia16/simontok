am4core.useTheme(am4themes_amcharts);



//GRAFIK PEMBIAYAAN PM PER TAHUN
var chartBiayaPMTahun = am4core.create("chartBiayaPMTahun", am4charts.XYChart);

chartBiayaPMTahun.data = dataBiayaPMTahun;
chartBiayaPMTahun.padding(10);

var categoryAxisBiayaPMTahun = chartBiayaPMTahun.yAxes.push(new am4charts.CategoryAxis());
categoryAxisBiayaPMTahun.renderer.grid.template.location = 0;
categoryAxisBiayaPMTahun.dataFields.category = "tahun";
categoryAxisBiayaPMTahun.renderer.minGridDistance = 20;
categoryAxisBiayaPMTahun.title.text = "Tahun";
categoryAxisBiayaPMTahun.title.fontWeight = "bold";
categoryAxisBiayaPMTahun.renderer.inversed = true;



var valueAxisBiayaPMTahun = chartBiayaPMTahun.xAxes.push(new am4charts.ValueAxis());
valueAxisBiayaPMTahun.title.text = "Biaya (Rp)";
valueAxisBiayaPMTahun.title.fontWeight = "bold";
valueAxisBiayaPMTahun.numberFormatter = new am4core.NumberFormatter();
valueAxisBiayaPMTahun.numberFormatter.numberFormat = "#,###.##";



var seriesBiayaPMTahun = chartBiayaPMTahun.series.push(new am4charts.ColumnSeries());
seriesBiayaPMTahun.dataFields.categoryY = "tahun";
seriesBiayaPMTahun.dataFields.valueX = "value";
seriesBiayaPMTahun.tooltipText = "Tahun {categoryY} : Rp {valueX.value.formatNumber('#,###.##')}";
seriesBiayaPMTahun.columns.template.strokeOpacity = 0;
seriesBiayaPMTahun.tooltip.exportable = true

var valueLabelBiayaPMTahun = seriesBiayaPMTahun.columns.template.createChild(am4core.Label);
valueLabelBiayaPMTahun.text = "Rp {value.formatNumber('#,###.##')}";
valueLabelBiayaPMTahun.fontSize = 14;
valueLabelBiayaPMTahun.fontWeight = "bold";
valueLabelBiayaPMTahun.valign = "middle";
valueLabelBiayaPMTahun.dx = 10;
valueLabelBiayaPMTahun.strokeWidth = 0;




chartBiayaPMTahun.cursor = new am4charts.XYCursor();
chartBiayaPMTahun.numberFormatter.numberFormat = "#.###,#####";
chartBiayaPMTahun.exporting.menu = new am4core.ExportMenu();
chartBiayaPMTahun.exporting.filePrefix = "grafik_jumlah_data_pembiayaan_pm_per_tahun";
chartBiayaPMTahun.exporting.menu.items = [
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
chartBiayaPMTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleBiayaPMTahun = chartBiayaPMTahun.titles.create();
titleBiayaPMTahun.text = "Grafik Pembiayaan Pemberdayaan Masyarakat per Tahun";
titleBiayaPMTahun.fontSize = 16;
titleBiayaPMTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesBiayaPMTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartBiayaPMTahun.colors.getIndex(target.dataItem.index);
});

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
chartDesaTerlibatTahun.numberFormatter.numberFormat = "#.###";
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

//GRAFIK UNIT KK TERLIBAT PER TAHUN 
var chartKKTerlibatTahun = am4core.create("chartKKTerlibatTahun", am4charts.XYChart3D);

chartKKTerlibatTahun.data = dataKKTerlibatTahun;
chartKKTerlibatTahun.padding(10);

var categoryAxisKKTerlibatTahun = chartKKTerlibatTahun.xAxes.push(new am4charts.CategoryAxis());
categoryAxisKKTerlibatTahun.renderer.grid.template.location = 0;
categoryAxisKKTerlibatTahun.dataFields.category = "tahun";
categoryAxisKKTerlibatTahun.renderer.minGridDistance = 20;
categoryAxisKKTerlibatTahun.title.text = "Tahun";
categoryAxisKKTerlibatTahun.title.fontWeight = "bold";



var valueAxisKKTerlibatTahun = chartKKTerlibatTahun.yAxes.push(new am4charts.ValueAxis());
valueAxisKKTerlibatTahun.title.text = "Jumlah";
valueAxisKKTerlibatTahun.title.fontWeight = "bold";

var seriesKKTerlibatTahun = chartKKTerlibatTahun.series.push(new am4charts.ColumnSeries3D());
seriesKKTerlibatTahun.dataFields.categoryX = "tahun";
seriesKKTerlibatTahun.dataFields.valueY = "value";
seriesKKTerlibatTahun.tooltipText = "Tahun {categoryX} : {valueY.value}";
seriesKKTerlibatTahun.columns.template.strokeOpacity = 0;
seriesKKTerlibatTahun.tooltip.exportable = true

var valueLabelKKTerlibatTahun = seriesKKTerlibatTahun.bullets.push(new am4charts.LabelBullet());
valueLabelKKTerlibatTahun.label.text = "{value}";
valueLabelKKTerlibatTahun.label.fontSize = 11;
valueLabelKKTerlibatTahun.label.fontWeight = "bold";
valueLabelKKTerlibatTahun.dy = 10;

chartKKTerlibatTahun.cursor = new am4charts.XYCursor();
chartKKTerlibatTahun.numberFormatter.numberFormat = "#.###,#####";
chartKKTerlibatTahun.exporting.menu = new am4core.ExportMenu();
chartKKTerlibatTahun.exporting.filePrefix = "grafik_jumlah_data_kk_terlibat_pdskk_per_tahun";
chartKKTerlibatTahun.exporting.menu.items = [
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
chartKKTerlibatTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleKKTerlibatTahun = chartKKTerlibatTahun.titles.create();
titleKKTerlibatTahun.text = "Grafik Jumlah Unit Kawasan Terlibat Pembinaan Desa";
titleKKTerlibatTahun.fontSize = 16;
titleKKTerlibatTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesKKTerlibatTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartKKTerlibatTahun.colors.getIndex(target.dataItem.index);
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

//GRAFIK RERATA PENDAPATAN PER TAHUN
var chartRataPendapatanTahun = am4core.create("chartRataPendapatanTahun", am4charts.XYChart);

chartRataPendapatanTahun.data = dataRataPendapatanTahun;
chartRataPendapatanTahun.padding(10);

var categoryAxisRataPendapatanTahun = chartRataPendapatanTahun.yAxes.push(new am4charts.CategoryAxis());
categoryAxisRataPendapatanTahun.renderer.grid.template.location = 0;
categoryAxisRataPendapatanTahun.dataFields.category = "tahun";
categoryAxisRataPendapatanTahun.renderer.minGridDistance = 20;
categoryAxisRataPendapatanTahun.title.text = "Tahun";
categoryAxisRataPendapatanTahun.title.fontWeight = "bold";
categoryAxisRataPendapatanTahun.renderer.inversed = true;



var valueAxisRataPendapatanTahun = chartRataPendapatanTahun.xAxes.push(new am4charts.ValueAxis());
valueAxisRataPendapatanTahun.title.text = "Rerata Pendapatan (Rp)";
valueAxisRataPendapatanTahun.title.fontWeight = "bold";
valueAxisRataPendapatanTahun.numberFormatter = new am4core.NumberFormatter();
valueAxisRataPendapatanTahun.numberFormatter.numberFormat = "#,###.##";



var seriesRataPendapatanTahun = chartRataPendapatanTahun.series.push(new am4charts.ColumnSeries());
seriesRataPendapatanTahun.dataFields.categoryY = "tahun";
seriesRataPendapatanTahun.dataFields.valueX = "value";
seriesRataPendapatanTahun.tooltipText = "Tahun {categoryY} : Rp {valueX.value.formatNumber('#,###.##')}";
seriesRataPendapatanTahun.columns.template.strokeOpacity = 0;
seriesRataPendapatanTahun.tooltip.exportable = true

var valueLabelRataPendapatanTahun = seriesRataPendapatanTahun.columns.template.createChild(am4core.Label);
valueLabelRataPendapatanTahun.text = "Rp {value.formatNumber('#,###.##')}";
valueLabelRataPendapatanTahun.fontSize = 14;
valueLabelRataPendapatanTahun.fontWeight = "bold";
valueLabelRataPendapatanTahun.valign = "middle";
valueLabelRataPendapatanTahun.dx = 10;
valueLabelRataPendapatanTahun.strokeWidth = 0;




chartRataPendapatanTahun.cursor = new am4charts.XYCursor();
chartRataPendapatanTahun.numberFormatter.numberFormat = "#.###,#####";
chartRataPendapatanTahun.exporting.menu = new am4core.ExportMenu();
chartRataPendapatanTahun.exporting.filePrefix = "grafik_jumlah_data_rerata_pendapatan_per_tahun";
chartRataPendapatanTahun.exporting.menu.items = [
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
chartRataPendapatanTahun.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871")
];
// Add chart title
var titleRataPendapatanTahun = chartRataPendapatanTahun.titles.create();
titleRataPendapatanTahun.text = "Grafik Rerata Pendapatan Kelompok per Tahun";
titleRataPendapatanTahun.fontSize = 16;
titleRataPendapatanTahun.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesRataPendapatanTahun.columns.template.adapter.add("fill", function (fill, target) {
    return chartRataPendapatanTahun.colors.getIndex(target.dataItem.index);
});