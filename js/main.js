function drawChart() {
    var t = $.ajax({ url: "get/get_ch.php", dataType: "json", async: !1 }).responseText,
        e = JSON.parse(t), 
        a = google.visualization.arrayToDataTable(e);
    new google.visualization.LineChart(document.getElementById("curve_chart")).draw(a, {
        chartArea: { left: "5%", top: "10%", bottom: "15%", width: "80%", height: "70%" },
        titleTextStyle: { color: "grey" },
        is3D: !0,
        title: "Atsiliepti skambučiai",
        curveType: "function",    //"function" "line"
        legend: { position: "right" },
    });
}
function main() {
    var t = dates(new Date()),
        e = new DayPilot.Locale("lt-lt", {
            dayNames: ["Sekmadienis", "Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis"],
            dayNamesShort: "Sk_Pr_An_Tr_Kt_Pn_Št".split("_"),
            monthNames: "Sausis_Vasaris_Kovas_Balandis_Gegužė_Birželis_Liepa_Rupgjūtis_Rugsėjis_Spalis_Lapkritis_Gruodis".split("_"),
            monthNamesShort: "Sau_Vas_Kov_Bal_Geg_Bir_Lie_Rgp_Rgs_Spa_Lap_Gru".split("_"),
            timePattern: "hh:mm:tt",
            datePattern: "yyyy-MM-dd",
            dateTimePattern: "yyyy-MM-dd HH:mm",
            timeFormat: "Clock24Hours",
            weekStarts: 1,
        });
    DayPilot.Locale.register(e);
    var a = new DayPilot.Navigator("nav2");
    (a.showMonths = 1),
        (a.skipMonths = 1),
        (a.selectMode = "week"),
        (a.locale = "lt-lt"),
        a.init(),
        (a.onTimeRangeSelected = function (t) {
            var e = t.day.toString().split("T")[0],
                a = dates(new Date(e));
            $("#sav_data").text("Savaitė " + a[0] + ":::" + a[6]),
                loadData("get_count.php?start=" + a[0] + "&end=" + a[6], document.getElementById("ats_per_sav"), 1),
                axios
                    .get("get/get_truk.php?start=" + a[0] + "&end=" + a[6])
                    .then(function (t) {
                        console.log(t.data), null != t.data.trukme ? $("#sav_tr").text("Bendra trukmė " + t.data.trukme) : $("#sav_tr").text("");
                    })
                    .catch(function (t) {
                        console.log(t);
                    }),
                axios
                    .get("get/get_vtruk.php?start=" + a[0] + "&end=" + a[6])
                    .then(function (t) {
                        console.log(t.data), null != t.data.vtrukme ? $("#sav_vtr").text("Vid. trukmė " + t.data.vtrukme) : $("#sav_vtr").text("");
                    })
                    .catch(function (t) {
                        console.log(t);
                    }),
                axios
                    .get("get/get_ne.php?start=" + a[0] + "&end=" + a[6])
                    .then(function (t) {
                        console.log(t.data), t.data.missed > 0 ? $("#sav_ne").text("Neatsiliepti " + t.data.missed) : $("#sav_ne").text("");
                    })
                    .catch(function (t) {
                        console.log(t);
                    });
            var n = month_first_last(new Date(e));
            $("#men_data").text("Mėnuo " + n[0] + ":::" + n[1]),
                loadData("get_count.php?start=" + n[0] + "&end=" + n[1], document.getElementById("ats_per_men"), 2),
                axios
                    .get("get/get_truk.php?start=" + n[0] + "&end=" + n[1])
                    .then(function (t) {
                        console.log(t.data), null != t.data.trukme ? $("#men_tr").text("Bendra trukmė " + t.data.trukme) : $("#men_tr").text("");
                    })
                    .catch(function (t) {
                        console.log(t);
                    }),
                axios
                    .get("get/get_vtruk.php?start=" + n[0] + "&end=" + n[1])
                    .then(function (t) {
                        console.log(t.data), null != t.data.vtrukme ? $("#men_vtr").text("Vid. trukmė " + t.data.vtrukme) : $("#men_vtr").text("");
                    })
                    .catch(function (t) {
                        console.log(t);
                    }),
                axios
                    .get("get/get_ne.php?start=" + n[0] + "&end=" + n[1])
                    .then(function (t) {
                        console.log(t.data), t.data.missed > 0 ? $("#men_ne").text("Neatsiliepti " + t.data.missed) : $("#men_ne").text("");
                    })
                    .catch(function (t) {
                        console.log(t);
                    });
        });
    t = dates(new Date());
    $("#sav_data").text("Savaitė " + t[0] + ":::" + t[6]),
        loadData("get_count.php?start=" + t[0] + "&end=" + t[6], document.getElementById("ats_per_sav"), 1),
        axios
            .get("get/get_truk.php?start=" + t[0] + "&end=" + t[6])
            .then(function (t) {
                console.log(t.data), null != t.data.trukme ? $("#sav_tr").text("Bendra trukmė " + t.data.trukme) : $("#sav_tr").text("");
            })
            .catch(function (t) {
                console.log(t);
            }),
        axios
            .get("get/get_vtruk.php?start=" + t[0] + "&end=" + t[6])
            .then(function (t) {
                console.log(t.data), null != t.data.vtrukme ? $("#sav_vtr").text("Vid. trukmė " + t.data.vtrukme) : $("#sav_vtr").text("");
            })
            .catch(function (t) {
                console.log(t);
            }),
        axios
            .get("get/get_ne.php?start=" + t[0] + "&end=" + t[6])
            .then(function (t) {
                console.log(t.data), t.data.missed > 0 ? $("#sav_ne").text("Neatsiliepti " + t.data.missed) : $("#sav_ne").text("");
            })
            .catch(function (t) {
                console.log(t);
            });
    var n = month_first_last(new Date());
    $("#men_data").text("Mėnuo " + n[0] + ":::" + n[1]),
        loadData("get_count.php?start=" + n[0] + "&end=" + n[1], document.getElementById("ats_per_men"), 2),
        axios
            .get("get/get_truk.php?start=" + n[0] + "&end=" + n[1])
            .then(function (t) {
                console.log(t.data), null != t.data.trukme ? $("#men_tr").text("Bendra trukmė " + t.data.trukme) : $("#men_tr").text("");
            })
            .catch(function (t) {
                console.log(t);
            }),
        axios
            .get("get/get_vtruk.php?start=" + n[0] + "&end=" + n[1])
            .then(function (t) {
                console.log(t.data), null != t.data.vtrukme ? $("#men_vtr").text("Vid. trukmė " + t.data.vtrukme) : $("#men_vtr").text("");
            })
            .catch(function (t) {
                console.log(t);
            }),
        axios
            .get("get/get_ne.php?start=" + n[0] + "&end=" + n[1])
            .then(function (t) {
                console.log(t.data), t.data.missed > 0 ? $("#men_ne").text("Neatsiliepti " + t.data.missed) : $("#men_ne").text("");
            })
            .catch(function (t) {
                console.log(t);
            });
    var o = new Date(),
        i = o.getFullYear();
    new Date(i, 0, 2).toISOString().slice(0, 10), o.toISOString().slice(0, 10);
}
function getIsduotus(t, e, a) {
    var n = "get_ataskaitos.php?start=" + t + "&end=" + e;
    $.get(n, function (n, o) {
        var i = JSON.parse(n);
        $(a).text("Nuo " + t + " iki " + e + " išduota dokumentų: " + i[0].isduota);
    });
}
function month_first_last(t) {
    var e = new Array(),
        a = t.getFullYear(),
        n = t.getMonth(),
        o = new Date(a, n, 2),
        i = new Date(a, n + 1, 1);
    return e.push(new Date(o).toISOString().slice(0, 10)), e.push(new Date(i).toISOString().slice(0, 10)), e;
}
function last_year() {
    var t = new Array(),
        e = new Date().getFullYear() - 1,
        a = new Date(e, 0, 2),
        n = new Date(e, 11, 32);
    return t.push(new Date(a).toISOString().slice(0, 10)), t.push(new Date(n).toISOString().slice(0, 10)), t;
}
function dates(t) {
    var e = new Array(),
        a = t.getDay();
    0 == a && (a = 7), t.setDate(t.getDate() - a + 1);
    for (var n = 0; n < 7; n++) e.push(new Date(t).toISOString().slice(0, 10)), t.setDate(t.getDate() + 1);
    return e;
}
var isd;
Vue.component("csv-component", {
    template: '<button @click="expo2(arr, failas)" >{{label}}</button>',
    props: ["arr", "label", "failas"],
    methods: {
        expo2: function (t, e) {
            let a = "data:text/csv;charset=utf-8,";
            a += [Object.keys(t[0]).join(";"), ...t.map((t) => Object.values(t).join(";"))].join("\n").replace(/(^\[)|(\]$)/gm, "");
            const n = encodeURI(a),
                o = document.createElement("a");
            o.setAttribute("href", n), o.setAttribute("download", e), o.click();
        },
    },
});
var MD5 = function (t) {
    return M(V(Y(X(t), 8 * t.length))).toLowerCase();
};
function M(t) {
    for (var e, a = "0123456789ABCDEF", n = "", o = 0; o < t.length; o++) (e = t.charCodeAt(o)), (n += a.charAt((e >>> 4) & 15) + a.charAt(15 & e));
    return n;
}
function X(t) {
    for (var e = Array(t.length >> 2), a = 0; a < e.length; a++) e[a] = 0;
    for (a = 0; a < 8 * t.length; a += 8) e[a >> 5] |= (255 & t.charCodeAt(a / 8)) << a % 32;
    return e;
}
function V(t) {
    for (var e = "", a = 0; a < 32 * t.length; a += 8) e += String.fromCharCode((t[a >> 5] >>> a % 32) & 255);
    return e;
}
function Y(t, e) {
    (t[e >> 5] |= 128 << e % 32), (t[14 + (((e + 64) >>> 9) << 4)] = e);
    for (var a = 1732584193, n = -271733879, o = -1732584194, i = 271733878, r = 0; r < t.length; r += 16) {
        var s = a,
            d = n,
            _ = o,
            l = i;
        (n = md5_ii(
            (n = md5_ii(
                (n = md5_ii(
                    (n = md5_ii(
                        (n = md5_hh(
                            (n = md5_hh(
                                (n = md5_hh(
                                    (n = md5_hh(
                                        (n = md5_gg(
                                            (n = md5_gg(
                                                (n = md5_gg(
                                                    (n = md5_gg(
                                                        (n = md5_ff(
                                                            (n = md5_ff(
                                                                (n = md5_ff(
                                                                    (n = md5_ff(
                                                                        n,
                                                                        (o = md5_ff(o, (i = md5_ff(i, (a = md5_ff(a, n, o, i, t[r + 0], 7, -680876936)), n, o, t[r + 1], 12, -389564586)), a, n, t[r + 2], 17, 606105819)),
                                                                        i,
                                                                        a,
                                                                        t[r + 3],
                                                                        22,
                                                                        -1044525330
                                                                    )),
                                                                    (o = md5_ff(o, (i = md5_ff(i, (a = md5_ff(a, n, o, i, t[r + 4], 7, -176418897)), n, o, t[r + 5], 12, 1200080426)), a, n, t[r + 6], 17, -1473231341)),
                                                                    i,
                                                                    a,
                                                                    t[r + 7],
                                                                    22,
                                                                    -45705983
                                                                )),
                                                                (o = md5_ff(o, (i = md5_ff(i, (a = md5_ff(a, n, o, i, t[r + 8], 7, 1770035416)), n, o, t[r + 9], 12, -1958414417)), a, n, t[r + 10], 17, -42063)),
                                                                i,
                                                                a,
                                                                t[r + 11],
                                                                22,
                                                                -1990404162
                                                            )),
                                                            (o = md5_ff(o, (i = md5_ff(i, (a = md5_ff(a, n, o, i, t[r + 12], 7, 1804603682)), n, o, t[r + 13], 12, -40341101)), a, n, t[r + 14], 17, -1502002290)),
                                                            i,
                                                            a,
                                                            t[r + 15],
                                                            22,
                                                            1236535329
                                                        )),
                                                        (o = md5_gg(o, (i = md5_gg(i, (a = md5_gg(a, n, o, i, t[r + 1], 5, -165796510)), n, o, t[r + 6], 9, -1069501632)), a, n, t[r + 11], 14, 643717713)),
                                                        i,
                                                        a,
                                                        t[r + 0],
                                                        20,
                                                        -373897302
                                                    )),
                                                    (o = md5_gg(o, (i = md5_gg(i, (a = md5_gg(a, n, o, i, t[r + 5], 5, -701558691)), n, o, t[r + 10], 9, 38016083)), a, n, t[r + 15], 14, -660478335)),
                                                    i,
                                                    a,
                                                    t[r + 4],
                                                    20,
                                                    -405537848
                                                )),
                                                (o = md5_gg(o, (i = md5_gg(i, (a = md5_gg(a, n, o, i, t[r + 9], 5, 568446438)), n, o, t[r + 14], 9, -1019803690)), a, n, t[r + 3], 14, -187363961)),
                                                i,
                                                a,
                                                t[r + 8],
                                                20,
                                                1163531501
                                            )),
                                            (o = md5_gg(o, (i = md5_gg(i, (a = md5_gg(a, n, o, i, t[r + 13], 5, -1444681467)), n, o, t[r + 2], 9, -51403784)), a, n, t[r + 7], 14, 1735328473)),
                                            i,
                                            a,
                                            t[r + 12],
                                            20,
                                            -1926607734
                                        )),
                                        (o = md5_hh(o, (i = md5_hh(i, (a = md5_hh(a, n, o, i, t[r + 5], 4, -378558)), n, o, t[r + 8], 11, -2022574463)), a, n, t[r + 11], 16, 1839030562)),
                                        i,
                                        a,
                                        t[r + 14],
                                        23,
                                        -35309556
                                    )),
                                    (o = md5_hh(o, (i = md5_hh(i, (a = md5_hh(a, n, o, i, t[r + 1], 4, -1530992060)), n, o, t[r + 4], 11, 1272893353)), a, n, t[r + 7], 16, -155497632)),
                                    i,
                                    a,
                                    t[r + 10],
                                    23,
                                    -1094730640
                                )),
                                (o = md5_hh(o, (i = md5_hh(i, (a = md5_hh(a, n, o, i, t[r + 13], 4, 681279174)), n, o, t[r + 0], 11, -358537222)), a, n, t[r + 3], 16, -722521979)),
                                i,
                                a,
                                t[r + 6],
                                23,
                                76029189
                            )),
                            (o = md5_hh(o, (i = md5_hh(i, (a = md5_hh(a, n, o, i, t[r + 9], 4, -640364487)), n, o, t[r + 12], 11, -421815835)), a, n, t[r + 15], 16, 530742520)),
                            i,
                            a,
                            t[r + 2],
                            23,
                            -995338651
                        )),
                        (o = md5_ii(o, (i = md5_ii(i, (a = md5_ii(a, n, o, i, t[r + 0], 6, -198630844)), n, o, t[r + 7], 10, 1126891415)), a, n, t[r + 14], 15, -1416354905)),
                        i,
                        a,
                        t[r + 5],
                        21,
                        -57434055
                    )),
                    (o = md5_ii(o, (i = md5_ii(i, (a = md5_ii(a, n, o, i, t[r + 12], 6, 1700485571)), n, o, t[r + 3], 10, -1894986606)), a, n, t[r + 10], 15, -1051523)),
                    i,
                    a,
                    t[r + 1],
                    21,
                    -2054922799
                )),
                (o = md5_ii(o, (i = md5_ii(i, (a = md5_ii(a, n, o, i, t[r + 8], 6, 1873313359)), n, o, t[r + 15], 10, -30611744)), a, n, t[r + 6], 15, -1560198380)),
                i,
                a,
                t[r + 13],
                21,
                1309151649
            )),
            (o = md5_ii(o, (i = md5_ii(i, (a = md5_ii(a, n, o, i, t[r + 4], 6, -145523070)), n, o, t[r + 11], 10, -1120210379)), a, n, t[r + 2], 15, 718787259)),
            i,
            a,
            t[r + 9],
            21,
            -343485551
        )),
            (a = safe_add(a, s)),
            (n = safe_add(n, d)),
            (o = safe_add(o, _)),
            (i = safe_add(i, l));
    }
    return Array(a, n, o, i);
}
function md5_cmn(t, e, a, n, o, i) {
    return safe_add(bit_rol(safe_add(safe_add(e, t), safe_add(n, i)), o), a);
}
function md5_ff(t, e, a, n, o, i, r) {
    return md5_cmn((e & a) | (~e & n), t, e, o, i, r);
}
function md5_gg(t, e, a, n, o, i, r) {
    return md5_cmn((e & n) | (a & ~n), t, e, o, i, r);
}
function md5_hh(t, e, a, n, o, i, r) {
    return md5_cmn(e ^ a ^ n, t, e, o, i, r);
}
function md5_ii(t, e, a, n, o, i, r) {
    return md5_cmn(a ^ (e | ~n), t, e, o, i, r);
}
function safe_add(t, e) {
    var a = (65535 & t) + (65535 & e);
    return (((t >> 16) + (e >> 16) + (a >> 16)) << 16) | (65535 & a);
}
function bit_rol(t, e) {
    return (t << e) | (t >>> (32 - e));
}
function drawPieChart(t, e, a, n, o) {
    for (var i, r = 0, s = 0, d = e.length, _ = 0; _ < d; _++) s += e[_].donors;
    (i = t.getContext("2d")).clearRect(0, 0, t.width, t.height);
    var l = ["#2F69BF", "#A2BF2F", "#BF5A2F", "#BFA22F", "#772FBF", "#2F94BF", "#c3d4db"];
    for (_ = 0; _ < d; _++) {
        (i.fillStyle = l[_]), i.beginPath(), i.moveTo(a, n), i.arc(a, n, o, r, r + 2 * Math.PI * (e[_].donors / s), !1), i.lineTo(a, n), i.fill();
        var m = 20 * _ + 10,
            c = 2 * o + 20;
        i.rect(c, m, 10, 10), (i.fillStyle = l[_]), i.fill(), (i.font = "italic 12px sans-serif"), (i.fillStyle = "#222");
        var u = e[_].location + " | " + e[_].donors;
        i.fillText(u, c + 18, m + 8), (r += 2 * Math.PI * (e[_].donors / s));
    }
}
function loadData(t, e, a) {
    var n = new XMLHttpRequest();
    n.open("GET", t, !0),
        (n.onreadystatechange = function () {
            if (4 == n.readyState)
                if ((n.status >= 200 && n.status < 300) || 304 === n.status) {
                    var t = n.responseText,
                        o = JSON.parse(t).ChartData;
                    drawPieChart(e, o.skmbSkaicius, 50, 50, 49);
                    var i = 0;
                    1 == a &&
                        ($.each(o.skmbSkaicius, function () {
                            i += this.donors;
                        }),
                        $("#ats_per_s_sk").text("Atsiliepta per savaitę (" + i + ")")),
                        2 == a &&
                            ($.each(o.skmbSkaicius, function () {
                                i += this.donors;
                            }),
                            $("#ats_per_m_sk").text("Atsiliepta per mėnesį (" + i + ")"));
                } else console.log(n.statusText), (tempContainer.innerHTML += '<p class="error">Error getting ' + target.name + ": " + n.statusText + ",code: " + n.status + "</p>");
        }),
        n.send();
}

