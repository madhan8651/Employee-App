function updateFilterSearch(form) {

    const searchBox = document.querySelector(
        '.search-box input[name="search"]'
    );

    const hiddenSearch = form.querySelector(
        'input[name="search"]'
    );

    if (searchBox && hiddenSearch) {

        hiddenSearch.value = searchBox.value;

    }

}