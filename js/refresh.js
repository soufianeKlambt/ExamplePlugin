setInterval(function (){
  console.log('refreshed');
  $('[widgetid=widgetWidgetKLAMBTdevices]').dashboardWidget('reload', false, true);
}, 800);
