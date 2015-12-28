$(document).on({
    ajaxStart: function() { $("body").addClass("loading").delay("500");    },
     ajaxStop: function() { $("body").delay("1000").removeClass("loading"); }    
});
