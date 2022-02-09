document.addEventListener("DOMContentLoaded", (e) => {
    const tom = document.querySelector(".tom-select-pr");

    const select = new TomSelect(tom, {
        create: false,
        sortField: {
            field: "text",
            direction: "asc",
        },
    });

    select.on("item_add", (value) => {
        const opt = document.querySelector(`option[value="${value}"]`);
        const json = JSON.parse(opt.dataset.json);
        const unit = document.querySelector(".input-unit");
        const cost = document.querySelector(".input-cost");

        unit.value = json.unit;
        cost.value = json.unit_cost;
    });
});

$("#kt_repeater_1").repeater({
    initEmpty: false,
    isFirstItemUndeletable: true,
    show: function () {
        const tom = this.querySelector(".tom-select-pr");

        const select = new TomSelect(tom, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc",
            },
        });

        select.on("item_add", (value) => {
            const opt = this.querySelector(`option[value="${value}"]`);
            const json = JSON.parse(opt.dataset.json);
            const unit = this.querySelector(".input-unit");
            const cost = this.querySelector(".input-cost");

            unit.value = json.unit;
            cost.value = json.unit_cost;
        });

        $(this).slideDown();
    },
    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    },
});
