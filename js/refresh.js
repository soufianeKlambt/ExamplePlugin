setInterval(function (){
  console.log('refreshed');
  $('#widgetWidgetKLAMBTdevices').closest('[widgetid=widgetWidgetKLAMBTdevices]').dashboardWidget('reload', false, true);
}, 1800);
