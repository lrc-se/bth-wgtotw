(function(win, doc) {
    "use strict";

    var toggle = doc.getElementById("menu-toggle");

    function forEach(sel, func) {
        Array.prototype.forEach.call(doc.querySelectorAll(sel), func);
    }

    function hideMenu(level) {
        forEach(".navbar .sub", function(el) {
            if (!level || +el.getAttribute("data-level") >= level) {
                el.classList.remove("open");
            }
        });
    }

    function toggleMenu(e) {
        e.preventDefault();
        e.stopPropagation();

        var item = e.currentTarget.parentElement;
        var isOpen = item.classList.contains("open");
        var level = +item.getAttribute("data-level");

        if (level == 1) {
            hideMenu();
        } else {
            hideMenu(level);
        }
        if (!isOpen) {
            item.classList.add("open");
        }
    }

    forEach(".navbar .sub > a, .navbar .sub > span", function(el) {
        el.addEventListener("click", toggleMenu);
    });
    doc.addEventListener("click", function() {
        hideMenu();
        if (toggle.classList.contains("open")) {
            toggle.classList.toggle("open");
        }
    });
    toggle.addEventListener("click", function(e) {
        e.stopPropagation();
        toggle.classList.toggle("open");
        hideMenu();
    });
})(window, document);
