setInterval(function (){
  console.log('refreshed');
  $('#widgetWidgetKLAMBTdevices').closest('[widgetid=widgetWidgetKLAMBTdevices]').dashboardWidget(null, false, true);
}, 1800);
