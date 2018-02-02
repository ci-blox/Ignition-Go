/**
 * Scripts for Frontend Website
 */
 
$(document).ready(function() {
	console.log("Frontend Website");
});

/* theme switcher - can be removed if not using in your app */
var themes = {
    "default": "./../assets/scss/themeig.css",
    "flat": "./../assets/scss/themefl.css",
    "elegant": "./../assets/scss/themeel.css",
    "neon": "./../assets/scss/themene.css",
    "aquamarine" : "./../assets/scss/themeaq.css",
    /* below are the bs3 themes - to be removed */
    "cerulean" : "//bootswatch.com/cerulean/bootstrap.min.css",
    "cosmo" : "//bootswatch.com/cosmo/bootstrap.min.css",
    "cyborg" : "//bootswatch.com/cyborg/bootstrap.min.css",
    "darkly" : "//bootswatch.com/darkly/bootstrap.min.css",
    "flatly" : "//bootswatch.com/flatly/bootstrap.min.css",
    "journal" : "//bootswatch.com/journal/bootstrap.min.css",
    "lumen" : "//bootswatch.com/lumen/bootstrap.min.css",
    "paper" : "//bootswatch.com/paper/bootstrap.min.css",
    "readable" : "//bootswatch.com/readable/bootstrap.min.css",
    "sandstone" : "//bootswatch.com/sandstone/bootstrap.min.css",
    "simplex" : "//bootswatch.com/simplex/bootstrap.min.css",
    "slate" : "//bootswatch.com/slate/bootstrap.min.css",
    "spacelab" : "//bootswatch.com/spacelab/bootstrap.min.css",
    "superhero" : "//bootswatch.com/superhero/bootstrap.min.css",
    "united" : "//bootswatch.com/united/bootstrap.min.css",
    "yeti"  : "//bootswatch.com/yeti/bootstrap.min.css"
}
var themesheet;
$(function(){
    themesheet = $('<link href="'+themes['default']+'" rel="stylesheet" />');
    themesheet.appendTo('head');
    $('.themelist a').click(function(e){  var themeurl = themes[$(this).attr('data-theme')]; 
        e.preventDefault();
		themesheet.attr('href',themeurl);
    });
});
/* end theme switcher */
