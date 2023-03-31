setInterval(function (){
  console.log('refreshed');
  this.$element.closest('[widgetid=widgetWidgetKLAMBTdevices]').dashboardWidget('reload', false, true);
}, 1800);
