document
    .getElementById("userForm")
    .addEventListener("submit", async function(event) {

        event.preventDefault();

        const form = this;

        const messageBox =
            document.getElementById("message");

        const formData =
            new FormData(form);

        messageBox.innerHTML = "";

        try {

            const response = await fetch(
                "/Employee_App/routes/api.php/users",
                {
                    method: "POST",
                    body: formData,
                    credentials: "same-origin"
                }
            );

            const result =
                await response.json();

            if (result.success) {

                messageBox.innerHTML =
                    '<div class="alert alert-success">' +
                    escapeHtml(result.message) +
                    '</div>';

                form.reset();

            } else {

                messageBox.innerHTML =
                    '<div class="alert alert-danger">' +
                    escapeHtml(result.message) +
                    '</div>';

            }

            setTimeout(function() {

                messageBox.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

            }, 100);

        } catch (error) {

            messageBox.innerHTML =
                '<div class="alert alert-danger">' +
                'Unable to connect to the server.' +
                '</div>';

            console.error(error);

        }

    });


function escapeHtml(value) {

    const div =
        document.createElement("div");

    div.textContent =
        value ?? "";

    return div.innerHTML;

}
