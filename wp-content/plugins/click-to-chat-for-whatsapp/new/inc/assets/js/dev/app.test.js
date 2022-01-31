!function(h) {
    h(function() {
        var t, a = window.location.href, o = void 0 !== document.title ? document.title : "", i = void 0 !== screen.width && 1024 < screen.width ? "no" : "yes", r = "";
        if ("undefined" != typeof ht_ctc_chat_var)
            r = ht_ctc_chat_var,
            e();
        else {
            try {
                document.querySelector(".ht-ctc-chat") && (t = h(".ht-ctc-chat").attr("data-settings"),
                r = JSON.parse(t))
            } catch (t) {
                r = {}
            }
            e()
        }
        function e() {
            var t;
            h(document).trigger("ht_ctc_ce_settings", [r]),
            (t = document.querySelector(".ht-ctc-chat")) && (h(t).trigger("ht_ctc_ce_chat"),
            function(t) {
                "yes" == r.schedule ? h(document).trigger("ht_ctc_display", [r, n, t]) : n(t)
            }(t),
            t.addEventListener("click", function() {
                !function(t) {
                    var e, n = r.number, c = r.pre_filled;
                    if (c = c.replace(/\[url]/gi, a),
                    c = encodeURIComponent(c),
                    "" == n)
                        return t.innerHTML = t.getAttribute("data-no_number");
                    "webapi" == r.webandapi ? (e = "yes" == i ? "https://api.whatsapp.com/send" : "https://web.whatsapp.com/send",
                    window.open(e + "?phone=" + n + "&text=" + c, "_blank", "noopener")) : (e = "https://wa.me/",
                    window.open(e + n + "?text=" + c, "_blank", "noopener"))
                }(t),
                s(t)
            })),
            h(document).on("click", ".ht-ctc-sc-chat", function() {
                var t, e = this.getAttribute("data-number"), n = (n = this.getAttribute("data-pre_filled")).replace(/\[url]/gi, a);
                n = encodeURIComponent(n),
                "webapi" == this.getAttribute("data-webandapi") ? (t = "yes" == i ? "https://api.whatsapp.com/send" : "https://web.whatsapp.com/send",
                window.open(t + "?phone=" + e + "&text=" + n, "_blank", "noopener")) : (t = "https://wa.me/",
                window.open(t + e + "?text=" + n, "_blank", "noopener")),
                s(this)
            })
        }
        function n(t) {
            var e;
            "yes" == i ? "show" == r.dis_m && ((e = document.querySelector(".ht_ctc_desktop_chat")) && e.remove(),
            t.style.cssText = r.pos_m + r.css,
            c(t)) : "show" == r.dis_d && ((e = document.querySelector(".ht_ctc_mobile_chat")) && e.remove(),
            t.style.cssText = r.pos_d + r.css,
            c(t))
        }
        function c(e) {
            try {
                h(e).show(parseInt(r.se))
            } catch (t) {
                e.style.display = "block"
            }
            var t;
            t = e,
            setTimeout(function() {
                t.classList.add("ht_ctc_animation", r.ani)
            }, 120),
            h(".ht-ctc-chat").hover(function() {
                h(".ht-ctc-chat .ht-ctc-cta-hover").show(120)
            }, function() {
                h(".ht-ctc-chat .ht-ctc-cta-hover").hide(100)
            })
        }
        function s(t) {
            h(document).trigger("ht_ctc_analytics");
            var e = r.number;
            t.classList.contains("ht-ctc-sc") && (e = t.getAttribute("data-number"));
            var n = "Click to Chat for WhatsApp"
              , c = "chat: " + e
              , t = o + ", " + a;
            "yes" == r.ga && ("undefined" != typeof gtag ? gtag("event", c, {
                event_category: n,
                event_label: t
            }) : "undefined" != typeof ga && void 0 !== ga.getAll ? ga.getAll()[0].send("event", n, c, t) : "undefined" != typeof __gaTracker && __gaTracker("send", "event", n, c, t)),
            "undefined" != typeof dataLayer && dataLayer.push({
                event: "Click to Chat",
                event_category: n,
                event_label: t,
                event_action: c
            }),
            "yes" == r.ads && "undefined" != typeof gtag_report_conversion && gtag_report_conversion(),
            "yes" == r.fb && "undefined" != typeof fbq && fbq("trackCustom", "Click to Chat by HoliThemes", {
                Category: "Click to Chat for WhatsApp",
                return_type: "chat",
                ID: e,
                Title: o,
                URL: a
            })
        }
    })
}(jQuery);
