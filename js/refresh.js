setInterval(function (){
  console.log('refreshed');
  $('#widgetWidgetKLAMBTdevices').dashboardWidget('reload', false, true);
}, 1800);
