document.addEventListener("DOMContentLoaded", (e) => {
    const toms = document.querySelectorAll(".tom-select");
    toms.forEach((tom) => {
        new TomSelect(tom, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc",
            },
        });
    });
});
