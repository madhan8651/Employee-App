const employeeForm =
    document.getElementById("employeeForm");

const messageBox =
    document.getElementById("message");

const submitButton =
    document.getElementById("submitButton");


employeeForm.addEventListener(
    "submit",
    async function (event) {

        event.preventDefault();


        const formData =
            new FormData(employeeForm);


        submitButton.disabled = true;

        submitButton.textContent =
            "Creating...";


        try {

            const response =
                await fetch(
                    employeeForm.action,
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
        `
        <div class="alert alert-success">
            ${result.message}
        </div>
        `;

    employeeForm.reset();

} else {

    messageBox.innerHTML =
        `
        <div class="alert alert-danger">
            ${result.message}
        </div>
        `;
}

setTimeout(function () {

    messageBox.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });

}, 100);


        } catch (error) {

    messageBox.innerHTML =
        `
        <div class="alert alert-danger">
            Unable to connect to Employee API.
        </div>
        `;

    setTimeout(function () {

        messageBox.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

    }, 100);
}


        submitButton.disabled = false;

        submitButton.textContent =
            "Create Employee";

    }
);