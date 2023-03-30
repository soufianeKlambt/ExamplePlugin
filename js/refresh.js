setInterval(function (){
  console.log('refreshed');
  $('[widgetid=widgetWidgetKLAMBTdevices]').bind('reload', false, true);
}, 1800);
