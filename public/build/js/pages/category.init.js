/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: category init js
*/

document.addEventListener('DOMContentLoaded', function () {
    // Convert Laravel category data into an array format suitable for Grid.js
    var categoryListAllData = JSON.parse(document.getElementById('category-data').textContent).map(cat => [
        cat.id, 
        cat.name,
        gridjs.html(`<button class="btn btn-success" onclick="editCategory(${cat.id})">Edit</button> <button class="btn btn-danger"  onclick="deleteCategory(${cat.id})">Delete</button>`)
    ]);

    // recomended-jobs
    if (document.getElementById("recomended-category")) {
        var categoryListAll = new gridjs.Grid({
            columns: [
                { name: 'ID', width: '50px' },
                { name: 'Category Title', width: '350px' },
                { name: 'Parent ID', width: '150px' },
                { name: 'Slug', width: '150px' },
                { name: 'Action', width: '150px' },
            ],
            sort: true,
            pagination: { limit: 10 },
            data: categoryListAllData,
        }).render(document.getElementById("recomended-category"));

        // Search feature
        var searchResultList = document.getElementById("searchResultList");
        searchResultList.addEventListener("keyup", function () {
            var inputVal = searchResultList.value.toLowerCase();

            function filterItems(arr, query) {
                return arr.filter(el => el.some(field => field.toString().toLowerCase().includes(query)));
            }

            var filterData = filterItems(categoryListAllData, inputVal);
            categoryListAll.updateConfig({ data: filterData }).forceRender();
        });
    }
});