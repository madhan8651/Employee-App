document.addEventListener("DOMContentLoaded", () => {

    const profileContainer =
        document.getElementById("profileContainer");

    if (profileContainer) {
        profileContainer.style.maxWidth = "700px";
        profileContainer.style.marginLeft = "auto";
        profileContainer.style.marginRight = "auto";
    }

    const message =
        document.getElementById("message");

    const csrfInput =
        document.getElementById("csrf_token");


    /*
    |--------------------------------------------------------------------------
    | SHOW MESSAGE
    |--------------------------------------------------------------------------
    */

    function showMessage(text, type = "success") {

        if (!message) {
            return;
        }

        message.textContent =
            text || "Something went wrong.";

        message.className =
            type === "success"
                ? "alert alert-success"
                : "alert alert-danger";

        message.setAttribute(
            "role",
            "alert"
        );

        message.setAttribute(
            "aria-live",
            "assertive"
        );

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

        setTimeout(() => {

            message.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        }, 100);

        clearTimeout(showMessage.timer);

        showMessage.timer =
            setTimeout(() => {

                message.textContent = "";

                message.className = "";

                message.removeAttribute("role");

                message.removeAttribute("aria-live");

            }, 4000);
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {
            return "";
        }

        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }


    /*
    |--------------------------------------------------------------------------
    | PROFILE PHOTO
    |--------------------------------------------------------------------------
    */

    function getProfilePhoto(employee) {

        if (
            employee.profile_photo &&
            employee.profile_photo.trim() !== ""
        ) {

            return `
                <img
                    src="/Employee_App/public/uploads/employees/${encodeURIComponent(employee.profile_photo)}"
                    alt="Profile Photo"
                    class="profile-photo"
                >
            `;
        }

        return `
            <div class="profile-photo placeholder">
                No Photo
            </div>
        `;
    }


    /*
    |--------------------------------------------------------------------------
    | API RESPONSE HANDLER
    |--------------------------------------------------------------------------
    */

    async function getJsonResponse(response) {

        const text =
            await response.text();

        let data;

        try {

            data =
                JSON.parse(text);

        }
        catch (error) {

            console.error(
                "Server response:",
                text
            );

            throw new Error(
                "Unable to process server response."
            );
        }

        if (
            !response.ok ||
            !data.success
        ) {

            throw new Error(
                data.message ||
                "Request failed. Please try again."
            );
        }

        return data;
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD EMPLOYEE PROFILE
    |--------------------------------------------------------------------------
    */

    function loadEmployeeProfile() {

        fetch(
            "/Employee_App/routes/api.php/employees/profile",
            {
                method: "GET",

                credentials: "same-origin",

                headers: {
                    "Accept": "application/json"
                }
            }
        )

        .then(response => {

            return getJsonResponse(response);

        })

        .then(data => {

            const employee =
                data.data;


            /*
            |--------------------------------------------------------------------------
            | PROFILE HTML
            |--------------------------------------------------------------------------
            */

            profileContainer.innerHTML = `

                <!-- =========================================
                     PROFILE PHOTO
                ========================================== -->

                <div class="profile-photo-section">

                    <div class="profile-photo-wrapper">

                        ${getProfilePhoto(employee)}

                    </div>

                </div>


                <!-- =========================================
                     PROFILE DETAILS
                ========================================== -->

                <div class="profile-details">


                    <!-- Employee ID -->

                    <div class="profile-row">

                        <span>
                            Employee ID
                        </span>

                        <strong>
                            ${escapeHtml(employee.employee_id)}
                        </strong>

                    </div>


                    <!-- First Name -->

                    <div class="profile-row">

                        <span>
                            First Name
                        </span>

                        <strong>
                            ${escapeHtml(employee.first_name)}
                        </strong>

                    </div>


                    <!-- Last Name -->

                    <div class="profile-row">

                        <span>
                            Last Name
                        </span>

                        <strong>
                            ${escapeHtml(employee.last_name)}
                        </strong>

                    </div>


                    <!-- Email -->

                    <div class="profile-row">

                        <span>
                            Email
                        </span>

                        <strong>
                            ${escapeHtml(employee.email)}
                        </strong>

                    </div>


                    <!-- Phone -->

                    <div class="profile-row">

                        <span>
                            Phone
                        </span>

                        <strong>
                            ${escapeHtml(employee.phone)}
                        </strong>

                    </div>


                    <!-- Date of Birth -->

                    <div class="profile-row">

                        <span>
                            Date of Birth
                        </span>

                        <strong>
                            ${escapeHtml(employee.date_of_birth)}
                        </strong>

                    </div>


                    <!-- Gender -->

                    <div class="profile-row">

                        <span>
                            Gender
                        </span>

                        <strong>
                            ${escapeHtml(employee.gender)}
                        </strong>

                    </div>


                    <!-- Date of Joining -->

                    <div class="profile-row">

                        <span>
                            Date of Joining
                        </span>

                        <strong>
                            ${escapeHtml(employee.date_of_joining)}
                        </strong>

                    </div>


                    <!-- Department -->

                    <div class="profile-row">

                        <span>
                            Department
                        </span>

                        <strong>
                            ${escapeHtml(employee.department || "-")}
                        </strong>

                    </div>


                    <!-- Designation -->

                    <div class="profile-row">

                        <span>
                            Designation
                        </span>

                        <strong>
                            ${escapeHtml(employee.designation)}
                        </strong>

                    </div>


                    <!-- Salary -->

                    <div class="profile-row">

                        <span>
                            Salary
                        </span>

                        <strong>
                            ${escapeHtml(employee.salary)}
                        </strong>

                    </div>


                    <!-- Address -->

                    <div class="profile-row">

                        <span>
                            Address
                        </span>

                        <strong>
                            ${escapeHtml(employee.address)}
                        </strong>

                    </div>


                    <!-- Status -->

                    <div class="profile-row">

                        <span>
                            Status
                        </span>

                        <strong>
                            ${escapeHtml(employee.status)}
                        </strong>

                    </div>


                </div>


                <!-- =========================================
                     PROFILE ACTIONS
                ========================================== -->

                <div class="profile-actions">

                    <button
                        type="button"
                        id="changePasswordButton"
                        class="profile-secondary-button"
                    >

                        <span class="action-icon">
                            🔑
                        </span>

                        Change Password

                    </button>


                    <button
                        type="button"
                        id="logoutButton"
                        class="profile-logout-button"
                    >

                        <span class="action-icon">
                            ➜
                        </span>

                        Logout

                    </button>

                </div>

            `;


            /*
            |--------------------------------------------------------------------------
            | EDIT PROFILE BUTTON
            |--------------------------------------------------------------------------
            */

            const editButton =
                document.getElementById(
                    "editProfileButton"
                );

            if (editButton) {

                editButton.addEventListener(
                    "click",
                    showEditForm
                );
            }


            /*
            |--------------------------------------------------------------------------
            | VIEW DEPARTMENT BUTTON
            |--------------------------------------------------------------------------
            */

            const viewDepartmentButton =
                document.getElementById(
                    "viewDepartmentButton"
                );

            if (viewDepartmentButton) {

                viewDepartmentButton.addEventListener(
                    "click",
                    () => {

                        /*
                         * Department page will be connected here.
                         */

                        window.location.href =
    "/Employee_App/routes/auth.php/employees/department";

                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CHANGE PASSWORD
            |--------------------------------------------------------------------------
            */

            const changePasswordButton =
                document.getElementById(
                    "changePasswordButton"
                );

            if (changePasswordButton) {

                changePasswordButton.addEventListener(
                    "click",
                    () => {

                        window.location.href =
                            "/Employee_App/routes/auth.php/change-password";

                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | LOGOUT
            |--------------------------------------------------------------------------
            */

            const logoutButton =
                document.getElementById(
                    "logoutButton"
                );

            if (logoutButton) {

                logoutButton.addEventListener(
                    "click",
                    () => {

                        window.location.href =
                            "/Employee_App/routes/auth.php/logout";

                    }
                );
            }

        })

        .catch(error => {

            console.error(
                "Load profile error:",
                error
            );

            showMessage(
                error.message ||
                "Unable to load your profile.",
                "error"
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW EDIT FORM
    |--------------------------------------------------------------------------
    */

    function showEditForm() {

        fetch(
            "/Employee_App/routes/api.php/employees/profile",
            {
                method: "GET",

                credentials: "same-origin",

                headers: {
                    "Accept": "application/json"
                }
            }
        )

        .then(response => {

            return getJsonResponse(response);

        })

        .then(data => {

            const employee =
                data.data;


            profileContainer.innerHTML = `

                <form
                    id="profileForm"
                    class="profile-edit-form"
                    enctype="multipart/form-data"
                >


                    <!-- =====================================
                         PROFILE PHOTO
                    ====================================== -->

                    <div class="profile-photo-section">

                        <div class="profile-photo-wrapper">

                            ${getProfilePhoto(employee)}


                            <label
                                for="profile_photo"
                                class="profile-photo-edit"
                                title="Change Photo"
                            >
                                ✎
                            </label>


                            <input
                                type="file"
                                id="profile_photo"
                                name="profile_photo"
                                accept="image/*"
                                hidden
                            >

                        </div>

                    </div>


                    <!-- =====================================
                         PROFILE DETAILS
                    ====================================== -->

                    <div class="profile-details">


                        <!-- Employee ID -->

                        <div class="profile-row">

                            <span>
                                Employee ID
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.employee_id
                                )}
                            </strong>

                        </div>


                        <!-- First Name -->

                        <div class="profile-row">

                            <span>
                                First Name
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.first_name
                                )}
                            </strong>

                        </div>


                        <!-- Last Name -->

                        <div class="profile-row">

                            <span>
                                Last Name
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.last_name
                                )}
                            </strong>

                        </div>


                        <!-- Email -->

                        <div class="profile-row">

                            <span>
                                Email
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.email
                                )}
                            </strong>

                        </div>


                        <!-- PHONE - EDITABLE -->

                        <div class="profile-row editable-row">

                            <span>
                                Phone
                            </span>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="${escapeHtml(
                                    employee.phone || ""
                                )}"
                            >

                        </div>


                        <!-- Date of Birth -->

                        <div class="profile-row">

                            <span>
                                Date of Birth
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.date_of_birth
                                )}
                            </strong>

                        </div>


                        <!-- Gender -->

                        <div class="profile-row">

                            <span>
                                Gender
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.gender
                                )}
                            </strong>

                        </div>


                        <!-- Date of Joining -->

                        <div class="profile-row">

                            <span>
                                Date of Joining
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.date_of_joining
                                )}
                            </strong>

                        </div>


                        <!-- Department -->

                        <div class="profile-row">

                            <span>
                                Department
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.department || "-"
                                )}
                            </strong>

                        </div>


                        <!-- Designation -->

                        <div class="profile-row">

                            <span>
                                Designation
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.designation
                                )}
                            </strong>

                        </div>


                        <!-- Salary -->

                        <div class="profile-row">

                            <span>
                                Salary
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.salary
                                )}
                            </strong>

                        </div>


                        <!-- ADDRESS - EDITABLE -->

                        <div class="profile-row editable-row">

                            <span>
                                Address
                            </span>

                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                            >${escapeHtml(
                                employee.address || ""
                            )}</textarea>

                        </div>


                        <!-- Status -->

                        <div class="profile-row">

                            <span>
                                Status
                            </span>

                            <strong>
                                ${escapeHtml(
                                    employee.status
                                )}
                            </strong>

                        </div>


                    </div>


                    <!-- =====================================
                         EDIT ACTIONS
                    ====================================== -->

                    <div class="profile-actions">

                        <button
                            type="submit"
                            class="profile-edit-button"
                        >
                            Save Changes
                        </button>


                        <button
                            type="button"
                            id="cancelEditButton"
                            class="profile-secondary-button"
                        >
                            Cancel
                        </button>

                    </div>


                </form>

            `;


            /*
            |--------------------------------------------------------------------------
            | FORM SUBMIT
            |--------------------------------------------------------------------------
            */

            const profileForm =
                document.getElementById(
                    "profileForm"
                );

            if (profileForm) {

                profileForm.addEventListener(
                    "submit",
                    updateProfile
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CANCEL EDIT
            |--------------------------------------------------------------------------
            */

            const cancelButton =
                document.getElementById(
                    "cancelEditButton"
                );

            if (cancelButton) {

                cancelButton.addEventListener(
                    "click",
                    loadEmployeeProfile
                );
            }


            /*
            |--------------------------------------------------------------------------
            | PHOTO PREVIEW
            |--------------------------------------------------------------------------
            */

            const photoInput =
                document.getElementById(
                    "profile_photo"
                );

            if (photoInput) {

                photoInput.addEventListener(
                    "change",
                    previewPhoto
                );
            }

        })

        .catch(error => {

            console.error(
                "Edit profile error:",
                error
            );

            showMessage(
                error.message ||
                "Unable to open edit profile.",
                "error"
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | PROFILE PHOTO PREVIEW
    |--------------------------------------------------------------------------
    */

    function previewPhoto(event) {

        const file =
            event.target.files[0];

        if (!file) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE IMAGE
        |--------------------------------------------------------------------------
        */

        if (!file.type.startsWith("image/")) {

            showMessage(
                "Please select a valid image file.",
                "error"
            );

            event.target.value = "";

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | FILE SIZE
        |--------------------------------------------------------------------------
        */

        const maxSize =
            5 * 1024 * 1024;

        if (file.size > maxSize) {

            showMessage(
                "Profile photo must be less than 5 MB.",
                "error"
            );

            event.target.value = "";

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PREVIEW
        |--------------------------------------------------------------------------
        */

        const reader =
            new FileReader();

        reader.onload =
            function () {

                const image =
                    document.querySelector(
                        ".profile-photo-wrapper .profile-photo"
                    );

                if (image) {

                    image.src =
                        reader.result;

                    return;
                }


                const placeholder =
                    document.querySelector(
                        ".profile-photo-wrapper .placeholder"
                    );

                if (placeholder) {

                    placeholder.outerHTML = `
                        <img
                            src="${reader.result}"
                            alt="Profile Photo"
                            class="profile-photo"
                        >
                    `;
                }

            };


        reader.readAsDataURL(file);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */

    function updateProfile(event) {

        event.preventDefault();


        const phoneInput =
            document.getElementById(
                "phone"
            );


        const addressInput =
            document.getElementById(
                "address"
            );


        const photoInput =
            document.getElementById(
                "profile_photo"
            );


        /*
        |--------------------------------------------------------------------------
        | CHECK FORM FIELDS
        |--------------------------------------------------------------------------
        */

        if (
            !phoneInput ||
            !addressInput
        ) {

            showMessage(
                "Profile form fields not found. Please try again.",
                "error"
            );

            return;
        }


        const phone =
            phoneInput.value.trim();


        const address =
            addressInput.value.trim();


        /*
        |--------------------------------------------------------------------------
        | PHONE VALIDATION
        |--------------------------------------------------------------------------
        */

        if (phone === "") {

            showMessage(
                "Phone number cannot be empty.",
                "error"
            );

            phoneInput.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PHONE FORMAT
        |--------------------------------------------------------------------------
        */

        const phonePattern =
            /^[0-9+\-\s()]{7,20}$/;


        if (!phonePattern.test(phone)) {

            showMessage(
                "Please enter a valid phone number.",
                "error"
            );

            phoneInput.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ADDRESS VALIDATION
        |--------------------------------------------------------------------------
        */

        if (address === "") {

            showMessage(
                "Address cannot be empty.",
                "error"
            );

            addressInput.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | CSRF TOKEN
        |--------------------------------------------------------------------------
        */

        if (!csrfInput) {

            showMessage(
                "Security token not found. Please refresh the page and try again.",
                "error"
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | FORM DATA
        |--------------------------------------------------------------------------
        */

        const formData =
            new FormData();


        formData.append(
            "csrf_token",
            csrfInput.value
        );


        formData.append(
            "phone",
            phone
        );


        formData.append(
            "address",
            address
        );


        /*
        |--------------------------------------------------------------------------
        | PROFILE PHOTO
        |--------------------------------------------------------------------------
        */

        if (
            photoInput &&
            photoInput.files &&
            photoInput.files.length > 0
        ) {

            formData.append(
                "profile_photo",
                photoInput.files[0]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE BUTTON
        |--------------------------------------------------------------------------
        */

        const saveButton =
            document.querySelector(
                "#profileForm button[type='submit']"
            );


        if (saveButton) {

            saveButton.disabled = true;

            saveButton.textContent =
                "Saving...";
        }


        /*
        |--------------------------------------------------------------------------
        | SEND REQUEST
        |--------------------------------------------------------------------------
        */

        fetch(
            "/Employee_App/routes/api.php/employees/profile",
            {
                method: "POST",

                credentials: "same-origin",

                body: formData
            }
        )

        .then(response => {

            return getJsonResponse(response);

        })

        .then(data => {

            /*
            |--------------------------------------------------------------------------
            | SUCCESS ALERT
            |--------------------------------------------------------------------------
            */

            showMessage(
                data.message ||
                "Profile updated successfully.",
                "success"
            );


            /*
            |--------------------------------------------------------------------------
            | RELOAD PROFILE
            |--------------------------------------------------------------------------
            */

            setTimeout(() => {

                loadEmployeeProfile();

            }, 1200);

        })

        .catch(error => {

            console.error(
                "Profile update error:",
                error
            );


            /*
            |--------------------------------------------------------------------------
            | ERROR ALERT
            |--------------------------------------------------------------------------
            */

            showMessage(
                error.message ||
                "Unable to update your profile. Please try again.",
                "error"
            );


            /*
            |--------------------------------------------------------------------------
            | ENABLE SAVE BUTTON
            |--------------------------------------------------------------------------
            */

            if (saveButton) {

                saveButton.disabled =
                    false;

                saveButton.textContent =
                    "Save Changes";
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    loadEmployeeProfile();

});