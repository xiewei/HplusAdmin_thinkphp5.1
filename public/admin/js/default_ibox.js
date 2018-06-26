$(".collapse-link").click(function() {
    var o = $(this).closest("div.ibox"),
    e = $(this).find("i"),
    i = o.find("div.ibox-content");
    i.slideToggle(200),
    e.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),
    o.toggleClass("").toggleClass("border-bottom"),
    setTimeout(function() {
        o.resize(),
        o.find("[id^=map-]").resize()
    },
    50)
})