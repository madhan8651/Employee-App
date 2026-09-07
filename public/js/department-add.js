const form =
    document.getElementById("departmentForm");

const message =
    document.getElementById("message");


const API_URL =
    "/Employee_App/routes/api.php/departments";


function escapeHtml(value)
{
    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


form.addEventListener(
    "submit",
    async function (event)
    {
        event.preventDefault();


        const formData =
            new FormData(form);


        try {

            const response =
                await fetch(
                    API_URL,
                    {
                        method: "POST",
                        body: formData,
                        credentials: "same-origin"
                    }
                );


            const result =
                await response.json();


            if (!response.ok || !result.success) {

                throw new Error(
                    result.message ||
                    "Unable to add department."
                );
            }


            message.innerHTML =
                `
                <div class="alert alert-success">
                    ${escapeHtml(result.message)}
                </div>
                `;


            form.reset();


            setTimeout(
                function ()
                {
                    window.location.href =
                        "index.php";
                },
                1000
            );


        } catch (error) {

            message.innerHTML =
                `
                <div class="alert alert-danger">
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }
);