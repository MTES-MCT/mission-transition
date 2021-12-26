import './styles/knowledge.scss';

import Isotope from 'isotope-layout'

document.addEventListener("DOMContentLoaded", function() {
    var elem = document.querySelector('#tag-filter-content');
    var iso = new Isotope( elem, {
        // options
        itemSelector: '.label-content',
        layoutMode: 'fitRows',
        filter: '.subvention',
        fitRows: {
            gutter: 32
        }
    });

    document.addEventListener('click', function (event) {

        if (!event.target.matches('.sort-aid-type')) return;
        event.preventDefault();
        let tags = document.getElementById('tag-filters');
        let activeTags = tags.getElementsByClassName('active');
        for (let tag of activeTags) {
            tag.classList.remove('active')
        }
        event.target.classList.add('active');
        var filterValue = event.target.getAttribute('data-filter');
        iso.arrange({ filter: filterValue });

    }, false);

    var elem2 = document.querySelector('#funders-filter-content');
    var iso2 = new Isotope( elem2, {
        // options
        itemSelector: '.funder-content',
        layoutMode: 'fitRows',
        filter: '.ademe',
        fitRows: {
            gutter: 32
        }
    });
    document.addEventListener('click', function (event) {

        if (!event.target.matches('.sort-funders')) return;
        event.preventDefault();
        let tags = document.getElementById('funders-filters');
        let activeTags = tags.getElementsByClassName('active');
        for (let tag of activeTags) {
            tag.classList.remove('active')
        }
        event.target.classList.add('active');
        var filterValue = event.target.getAttribute('data-filter');
        iso2.arrange({ filter: filterValue });

    }, false);

    var elem3 = document.querySelector('#aids-filter-content');
    var iso3 = new Isotope( elem3, {
        // options
        itemSelector: '.aids-content',
        layoutMode: 'fitRows',
        fitRows: {
            gutter: 32
        }
    });

    document.addEventListener('click', function (event) {

        if (!event.target.matches('.sort-aids')) return;
        event.preventDefault();
        let tags = document.getElementById('aids-filters');
        let activeTags = tags.getElementsByClassName('active');
        for (let tag of activeTags) {
            tag.classList.remove('active')
        }
        event.target.classList.add('active');
        var filterValue = event.target.getAttribute('data-filter');
        iso3.arrange({ filter: filterValue });

    }, false);

    document.addEventListener('click', function (event) {
        if (!event.target.matches('#tabpanel-405')) return;
        let funderBaseTag = document.getElementById('ademe-filter');
        funderBaseTag.click();
    }, false);
});
