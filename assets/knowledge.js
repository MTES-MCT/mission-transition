import './styles/knowledge.scss';

import Isotope from 'isotope-layout'

let showMoreButton = document.querySelector('#show-more > .button');
showMoreButton.addEventListener('click', () => {
    let showMoreItems = document.querySelectorAll('#show-more > .hidden');
    for (let i = 0; i < 3; i++) {
        showMoreItems[i].classList.toggle('hidden');
    }

    showMoreItems = document.querySelectorAll('#show-more > .hidden');
    if (showMoreItems.length === 0) {
        showMoreButton.classList.add('hidden');
    }
});

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
            tag.classList.remove('active');
            tag.setAttribute('aria-pressed', 'false');
        }
        event.target.classList.add('active');
        event.target.setAttribute('aria-pressed', 'true');
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
            tag.classList.remove('active');
            tag.setAttribute('aria-pressed', 'false');
        }
        event.target.classList.add('active');
        event.target.setAttribute('aria-pressed', 'true');
        var filterValue = event.target.getAttribute('data-filter');
        iso2.arrange({ filter: filterValue });

    }, false);

    document.addEventListener('click', function (event) {
        if (!event.target.matches('#tabpanel-405')) return;
        let funderBaseTag = document.getElementById('ademe-filter');
        funderBaseTag.click();
    }, false);
