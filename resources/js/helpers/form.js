const serialize = require("form-serialize");
const forms = document.querySelectorAll("form.ajax_form");

forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const datas = serialize(form, { hash: true });
        const datasURL = serialize(form);




        const method = datas._method;

        const strify = new URLSearchParams(datas);
        // console.log(datas, method);
        // console.log(strify.toString())
        // return;

        // adding class to form
        form.classList.add("whirl", "traditional");

        axios({
            method: method,
            url: form.getAttribute("action"),
            data: datasURL,
        })
            .then((response) => {
                const res = response.data;
                Swal.fire({
                    title: res.title ?? 'Success',
                    text: res.message ?? 'Action has been executed successfully.',
                    icon: "success",
                    confirmButtonText: "Ok",
                }).then(() => {
                    if ("intended" in res) window.location = res.intended
                    form.reset()
                });
            })
            .catch(function (error) {
                const response = error.response;

                let title, message;

                switch (response.status) {
                    default:
                        title = response.statusText ?? "Ooops..";
                        message =
                            response.data.message ?? "Something went wrong";
                        break;
                }

                Swal.fire({
                    icon: "error",
                    title: title,
                    text: message,
                });
            })
            .finally(() => {
                form.classList.remove("whirl", "traditional");
            });
    });
});
