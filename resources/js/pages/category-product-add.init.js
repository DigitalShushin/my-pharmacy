/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: category product add Js File
*/

// Form Event
(function () {
    'use strict';

    var form = document.getElementById('addcategory-form');

    if (!form) {
        console.error("Form with ID 'addcategory-form' not found.");
        return;
    }

    // Date & Time
    var date = new Date().toUTCString().slice(5, 16);

    function currentTime() {
        var now = new Date();
        var ampm = now.getHours() >= 12 ? "PM" : "AM";
        var hour = now.getHours() > 12 ? now.getHours() % 12 : now.getHours();
        var minute = now.getMinutes() < 10 ? "0" + now.getMinutes() : now.getMinutes();
        return (hour < 10 ? "0" + hour : hour) + ":" + minute + " " + ampm;
    }

    // Form Submission Event
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        var categoryNameValue = document.getElementById("category-name-input").value;
        var formAction = document.getElementById("formAction").value;

        var formData = new FormData();
        formData.append('name', categoryNameValue);
        formData.append('publishDate', date);
        formData.append('publishTime', currentTime());

        var url = formAction === "add" ? '{{ route("category.store") }}' : '{{ route("category.update", ":id") }}'.replace(":id", document.getElementById("category-id-input").value);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.replace("apps-category");
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
})();


