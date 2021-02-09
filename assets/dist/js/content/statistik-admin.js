am4core.useTheme(am4themes_amcharts);

//GRAFIK realisasi pengesahan per jurusan
var chartRealisasiSahJurusan = am4core.create("chartRealisasiSahJurusan", am4charts.XYChart);

chartRealisasiSahJurusan.data = dataRealisasiSahJurusan;
console.log(dataRealisasiSahJurusan);
chartRealisasiSahJurusan.padding(10);

var categoryAxisRealisasiSahJurusan = chartRealisasiSahJurusan.yAxes.push(new am4charts.CategoryAxis());
categoryAxisRealisasiSahJurusan.renderer.grid.template.location = 0;
categoryAxisRealisasiSahJurusan.dataFields.category = "nama_jurusan";
categoryAxisRealisasiSahJurusan.renderer.minGridDistance = 20;
categoryAxisRealisasiSahJurusan.title.text = "Jurusan";
categoryAxisRealisasiSahJurusan.title.fontWeight = "bold";
categoryAxisRealisasiSahJurusan.renderer.inversed = true;



var valueAxisRealisasiSahJurusan = chartRealisasiSahJurusan.xAxes.push(new am4charts.ValueAxis());
valueAxisRealisasiSahJurusan.title.text = "Presentase Realisasi Anggaran";
valueAxisRealisasiSahJurusan.title.fontWeight = "bold";
valueAxisRealisasiSahJurusan.numberFormatter.numberFormat = "#,###.##";


var seriesRealisasiSahJurusan = chartRealisasiSahJurusan.series.push(new am4charts.ColumnSeries());
seriesRealisasiSahJurusan.dataFields.categoryY = "nama_jurusan";
seriesRealisasiSahJurusan.dataFields.valueX = "persen";
seriesRealisasiSahJurusan.tooltipText = "{categoryY} : {valueX.value.formatNumber('#,###.##')}%";
seriesRealisasiSahJurusan.columns.template.strokeOpacity = 0;
seriesRealisasiSahJurusan.tooltip.exportable = true

var valueLabelRealisasiSahJurusan = seriesRealisasiSahJurusan.columns.template.createChild(am4core.Label);
valueLabelRealisasiSahJurusan.text = "{valueX.value.formatNumber('#,###.##')}%";
valueLabelRealisasiSahJurusan.fontSize = 14;
valueLabelRealisasiSahJurusan.fontWeight = "bold";
valueLabelRealisasiSahJurusan.valign = "middle";
valueLabelRealisasiSahJurusan.dx = 10;
valueLabelRealisasiSahJurusan.strokeWidth = 0;




chartRealisasiSahJurusan.cursor = new am4charts.XYCursor();
chartRealisasiSahJurusan.numberFormatter.numberFormat = "#,###.##";
chartRealisasiSahJurusan.exporting.menu = new am4core.ExportMenu();
chartRealisasiSahJurusan.exporting.filePrefix = "grafik_jumlah_data_realisasi_sah_per_jurusan";
chartRealisasiSahJurusan.exporting.menu.items = [
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
chartRealisasiSahJurusan.colors.list = [
  am4core.color("#845EC2"),
  am4core.color("#D65DB1"),
  am4core.color("#FF6F91"),
  am4core.color("#FF9671"),
  am4core.color("#FFC75F"),
  am4core.color("#F9F871"),
  am4core.color("#97eb57"),
  am4core.color("#adcfa3"),
  am4core.color("#7cf2bf"),
  am4core.color("#46aef0"),
  am4core.color("#ae59f0"),
  am4core.color("#f72df1"),
  am4core.color("#f29933"),
  am4core.color("#f2bf33")
];
chartRealisasiSahJurusan.numberFormatter.bigNumberPrefixes = [
  { "number": 1e+3, "suffix": " Ribu" },
  { "number": 1e+6, "suffix": " Juta" },
  { "number": 1e+9, "suffix": " M" },
  { "number": 1e+12, "suffix": " T" }
];
// Add chart title
var titleRealisasiSahJurusan = chartRealisasiSahJurusan.titles.create();
titleRealisasiSahJurusan.text = "Grafik Realisasi Anggaran per Jurusan";
titleRealisasiSahJurusan.fontSize = 16;
titleRealisasiSahJurusan.marginBottom = 10;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
seriesRealisasiSahJurusan.columns.template.adapter.add("fill", function (fill, target) {
    return chartRealisasiSahJurusan.colors.getIndex(target.dataItem.index);
});
