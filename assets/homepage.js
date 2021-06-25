import './styles/homepage.scss';
import Isotope from 'isotope-layout'

document.addEventListener("DOMContentLoaded", function() {
    var elem = document.querySelector('#tag-filter-content');
    var iso = new Isotope( elem, {
        // options
        itemSelector: '.card-package',
        layoutMode: 'fitRows',
        fitRows: {
            gutter: 32
        }
    });

    document.addEventListener('click', function (event) {

        if (!event.target.matches('.sort-package')) return;
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
});
