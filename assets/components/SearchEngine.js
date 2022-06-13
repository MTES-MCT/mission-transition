import React, { useState, useEffect } from "react";
import {
    fetchAids,
    fetchGeographicalAreas,
    fetchAidTypes,
    fetchProjectStatus,
    fetchTopics} from "./Api";

const SearchEngine = () => {
    let params = new URLSearchParams(window.location.search);
    let initialGeographicalAreaId = '';
    let initialAidTypeId = '';
    let initialProjectStatusId = '';
    let initialTopicId = '';
    let initialSubTopicId = '';
    let initialCurrentPageNumber = 1;
    let initialCurrentPath = '/api/aides?itemsPerPage=10&page=1';
    let initialDescription = '';

    if (params.has('region')) {
        initialGeographicalAreaId = params.get('region');
    }
    if (params.has('aidType')) {
        initialAidTypeId = params.get('aidType');
    }
    if (params.has('projectStatus')) {
        initialProjectStatusId = params.get('projectStatus');
    }
    if (params.has('topic')) {
        initialTopicId = params.get('topic');
    }
    if (params.has('subTopic')) {
        initialSubTopicId = params.get('subTopic');
    }
    if (params.has('description')) {
        initialDescription = params.get('description');
    }
    if (params.has('page')) {
        const page = parseInt(params.get('page'));
        initialCurrentPageNumber = page;
        initialCurrentPath = `/api/aides?itemsPerPage=10&page=${page}`;
    }
    const [aids, setAids] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    // Pagination
    const [totalItems, setTotalItems] = useState(true);
    const [firstPagePath, setFirstPagePath] = useState(undefined);
    const [lastPagePath, setLastPagePath] = useState(undefined);
    const [previousPagePath, setPreviousPagePath] = useState(undefined);
    const [nextPagePath, setNextPagePath] = useState(undefined);
    const [currentPagePath, setCurrentPagePath] = useState(initialCurrentPath);
    const [currentPageNumber, setCurrentPageNumber] = useState(initialCurrentPageNumber);
    const [lastPageNumber, setLastPageNumber] = useState(1);

    // Filters options
    const [geographicalAreas, setGeographicalAreas] = useState([]);
    const [aidTypes, setAidTypes] = useState([]);
    const [projectStatus, setProjectStatus] = useState([]);
    const [topics, setTopics] = useState([]);
    const [subTopics, setSubTopics] = useState([]);
    const [searchValue, setSearchValue] = useState('');

    // Selected Filters
    const [selectedGeographicalAreaId, setSelectedGeographicalAreaId] = useState(initialGeographicalAreaId);
    const [selectedAidTypeId, setSelectedAidTypeId] = useState(initialAidTypeId);
    const [selectedProjectStatusId, setSelectedProjectStatusId] = useState(initialProjectStatusId);
    const [selectedTopicId, setSelectedTopicId] = useState(initialTopicId);
    const [selectedSubTopicId, setSelectedSubTopicId] = useState(initialSubTopicId);
    const [appliedTag, setAppliedTag] = useState(initialDescription);

    useEffect(async() => {
        setGeographicalAreas(await fetchGeographicalAreas());
        setAidTypes(await fetchAidTypes());
        setProjectStatus(await fetchProjectStatus());
        const fetchedTopics = await fetchTopics();
        setTopics(fetchedTopics);
        if (params.has('topic')) {
            const selectedTopic = fetchedTopics.find(t => t.id === parseInt(params.get('topic')));
            if (selectedTopic) {
                setSelectedTopicId(selectedTopic.id);
                setSubTopics(selectedTopic.sousThematique)
            }
        }
    }, [])

    useEffect(() => {
        params.set('region', selectedGeographicalAreaId);
        params.set('aidType', selectedAidTypeId);
        params.set('projetStatus', selectedProjectStatusId);
        params.set('subTopic', selectedSubTopicId);
        params.set('topic', selectedTopicId);
        params.set('description', appliedTag);
        if (params.has('page') && params.get('page') <= currentPageNumber.toString()) {
            params.set('page', '1');
            setCurrentPageNumber(1);
            setCurrentPagePath('/api/aides?itemsPerPage=10&page=1');
        }
        window.history.replaceState({}, '', `${location.pathname}?${params}`);
        const fetchData = async () => {
            setIsLoading(true);
            let response = await fetchAids(
                selectedGeographicalAreaId,
                selectedAidTypeId,
                selectedProjectStatusId,
                selectedSubTopicId,
                selectedTopicId,
                appliedTag,
                currentPagePath
            );
            setTotalItems(response['hydra:totalItems']);
            setFirstPagePath(response['hydra:view']['hydra:first']);
            setLastPagePath(response['hydra:view']['hydra:last']);
            if (response['hydra:view']['hydra:last'] !== undefined) {
                let urlParams = new URLSearchParams(response['hydra:view']['hydra:last']);
                setLastPageNumber(parseInt(urlParams.get('page')));
            } else {
                setLastPageNumber(1);
            }
            setPreviousPagePath(response['hydra:view']['hydra:previous']);
            setNextPagePath(response['hydra:view']['hydra:next'])
            let urlParams = new URLSearchParams(currentPagePath);
            setCurrentPageNumber(parseInt(urlParams.get('page')));
            setAids(response['hydra:member']);

            setIsLoading(false);
        }

        fetchData();
    }, [selectedGeographicalAreaId, selectedAidTypeId, selectedProjectStatusId, selectedTopicId, selectedSubTopicId, currentPagePath, appliedTag]);


    const getGeographicalZoneNames = (geographicalZones) => {
        return geographicalZones.map(zone => zone.nom).join(', ');
    }

    const getFormattedDate = date => {
        return new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium'}).format(new Date(date))
    }

    const handleNationalAidsCtaClick = e => {
        e.preventDefault();
        setSelectedGeographicalAreaId(geographicalAreas.find(t => t.nom === "France").id);
    }

    const isTimeForLyonCard = (index) => {
        if (geographicalAreas.length === 0) {
            return false;
        }

        if (index !== 4) {
            return false;
        }

        return parseInt(selectedGeographicalAreaId) === geographicalAreas.find(t => t.nom === "Auvergne-Rhône-Alpes").id;
    }

    const getNationalAidsCta = () => {
        return (
            <div className="mt-text-align-center fr-mb-3w" key={999}>
                <a className="fr-btn" href="#search-input" onClick={handleNationalAidsCtaClick}>Cliquez ici pour retrouver les aides nationales</a>
            </div>
        )
    }

    const getAidsCards = () => {
        if (isLoading) {
            return <div className="fr-grid-row fr-grid-row--center">
                <div className="fr-col-12 fr-pt-5w mt-text-align-center">
                    <h2 className="color-navy">Un instant, nous recherchons les aides disponibles...</h2>
                </div>
            </div>
        }

        if (aids.length === 0 && !isLoading) {
            return <div className="fr-grid-row fr-grid-row--center">
                <div className="fr-col-12 mt-text-align-center">
                    <img src="build/img/illu4.svg" alt="Pas de résultats"/>
                </div>
                <div className="fr-col-12 fr-pt-5w mt-text-align-center">
                    <h2 className="color-navy">Aucune aide n’a pu être identifiée avec les critères choisis...</h2>
                </div>
                <div className="fr-col-12 fr-pt-3w mt-text-align-center">
                    <p>Essayez un autre mot-clé ou sélectionnez moins de filtres peut-être ? </p>
                </div>
            </div>
        }

        let aidCards = aids.map((aid, index) =>
            <>
                <div className="fr-card fr-enlarge-link fr-card--horizontal fr-mb-3w" key={aid.id}>
                    <div className="fr-card__body">
                        <div className="fr-card__content">
                            <h4 className="fr-card__title">
                                <a href={"/recherche/dispositif/" + aid.slug}>{aid.nomAideNormalise}</a>
                            </h4>
                            <div className="fr-card__start">
                                <p className="fr-card__detail fr-icon-warning-fill"></p>
                            </div>
                            <div className="fr-card__end">
                                <div className="fr-card__icons fr-pb-3w">
                                    {aid.zonesGeographiques.length > 0 && (
                                        <div>
                                            <span className="mt-icon-wrapper mt-icon-wrapper--inline">
                                                <span className="mt-icon mt-icon--tag"></span>
                                            </span>
                                            <span className="subtitle">{getGeographicalZoneNames(aid.zonesGeographiques)}</span>
                                        </div>
                                    )}
                                    {aid.aapAmi && (
                                        <div>
                                            <span className="mt-icon-wrapper mt-icon-wrapper--inline">
                                                <span className="mt-icon mt-icon--euro"></span>
                                            </span>
                                            <span className="subtitle">Appel à projet</span>
                                        </div>
                                    )}
                                    {aid.dateCloture && (
                                        <div>
                                            <span className="mt-icon-wrapper mt-icon-wrapper--inline">
                                                <span className="mt-icon mt-icon--time"></span>
                                            </span>
                                            <span className="subtitle">Date de clôture : {getFormattedDate(aid.dateCloture)}</span>
                                        </div>
                                    )}
                                </div>
                                <p className="fr-card__detail fr-icon-warning-fill">Proposé par {aid.porteursAide.join(', ')}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {isTimeForLyonCard(index) && (
                    <div className="fr-card fr-card--horizontal fr-mb-3w region-card" key={aid.id * 1000}>
                        <div className="fr-card__body">
                            <div className="fr-card__content">
                                <h4 className="fr-card__title color-navy">
                                    Entreprise industrielle ? Consultez le guide pratique de la Métropole de Lyon !
                                </h4>
                                <div className="fr-card__end">
                                    <div>
                                        <a target="_blank" href="https://business.onlylyon.com/actualites/article/publication-du-guide-des-dispositifs-d-accompagnement-a-la-transition-ecologique-pour-les-entreprises-industrielles-de-la-metropole-de-lyon" className="fr-btn fr-btn--secondary">
                                            Consulter le guide
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="fr-card__header">
                            <div className="fr-card__img">
                                <img className="fr-responsive-img" src="build/img/illu_metropole_lyon.png"
                                     alt="Métropole de Lyon"/>
                            </div>
                        </div>
                    </div>
                )}
            </>
        );

        if (geographicalAreas.length > 0 &&
            parseInt(selectedGeographicalAreaId) !== geographicalAreas.find(t => t.nom === "France").id &&
            currentPageNumber === lastPageNumber) {
            aidCards = [aidCards, getNationalAidsCta()]
        }

        return aidCards;
    }

    const onPaginationClick = (newPath) => {
        if (newPath === undefined) {
            return false;
        }
        let urlParams = new URLSearchParams(newPath);
        params.set('page', urlParams.get('page'));
        window.history.replaceState({}, '', `${location.pathname}?${params}`);

        setCurrentPagePath(newPath);
    }

    const getPagination = () => {
        return <nav role="navigation" className="fr-pagination" aria-label="Pagination">
            <ul className="fr-pagination__list">
                <li>
                    <a className="fr-pagination__link fr-pagination__link--first"
                       href={currentPageNumber <= 1 ? undefined : '#'}
                       onClick={e => onPaginationClick(firstPagePath)}
                       aria-disabled={currentPageNumber <= 1}
                       role="link">
                        Première page
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link fr-pagination__link--prev fr-pagination__link--lg-label"
                       aria-disabled={currentPageNumber <= 1}
                       href={currentPageNumber <= 1 ? undefined : '#'}
                       onClick={e => onPaginationClick(previousPagePath)}
                       role="link">
                        Page précédente
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link" aria-current="page" title={"Page" + currentPageNumber}>
                        {currentPageNumber}
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link fr-pagination__link--next fr-pagination__link--lg-label"
                       href={currentPageNumber >= lastPageNumber ? undefined : '#'}
                       aria-disabled={currentPageNumber >= lastPageNumber}
                       onClick={e => onPaginationClick(nextPagePath)}
                       role="link">
                        Page suivante
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link fr-pagination__link--last"
                       onClick={e => onPaginationClick(lastPagePath)}
                       href={currentPageNumber >= lastPageNumber ? undefined : '#'}
                       aria-disabled={currentPageNumber >= lastPageNumber}
                       role="link">
                        Dernière page
                    </a>
                </li>
            </ul>
        </nav>
    }

    const getMappedOptions = (items, valueField, valueNameField) => {
        return items.map((item, index) => <option
            key={index}
            value={item[valueField]}>{item[valueNameField]}
        </option>)
    }

    const handleTopicChange = e => {
        e.preventDefault();
        if (e.target.value === "") {
            setSelectedTopicId('');
            return;
        }

        const selectedTopic = topics.find(t => t.id === parseInt(e.target.value));
        if (selectedTopic) {
            params.set('topic', selectedTopic.id);
            window.history.replaceState({}, '', `${location.pathname}?${params}`);
            setSelectedTopicId(selectedTopic.id);
            setSubTopics(selectedTopic.sousThematique)
        }
    }

    const handleSearchInput = e => {
        e.preventDefault();
        setSearchValue(e.target.value);
    }

    const handleSearchSubmit = e => {
        e.preventDefault();
        setAppliedTag(searchValue);
        setCurrentPageNumber(1);
        setCurrentPagePath('/api/aides?itemsPerPage=10&page=1');
        params.set('page', '1');
    }

    const handleKeyDown = e => {
        if (e.key !== "Enter") {
            return;
        }
        setAppliedTag(searchValue);
        setCurrentPageNumber(1);
        setCurrentPagePath('/api/aides?itemsPerPage=10&page=1');
        params.set('page', '1');
    }

    const handleTagDeletion = e => {
        e.preventDefault();
        setAppliedTag('');
    }

    return (
      <div className="fr-container">
        <div className="fr-grid-row fr-grid-row--center fr-pt-8w fr-pb-3w fr-pb-md-8w">
            <div className="fr-col-12">
                <div className="fr-search-bar fr-search-bar--lg" id="search-2" role="search">
                    <label className="fr-label" htmlFor="search-input">
                        Rechercher un mot, une expression, une référence...
                    </label>
                    <input className="fr-input" placeholder="Rechercher un mot, une expression, une référence..." type="search" id="search-input"
                           name="search-input" value={searchValue} onChange={handleSearchInput} onKeyDown={handleKeyDown}/>
                    <button onClick={handleSearchSubmit} className="fr-btn">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
        <div className="fr-grid-row">
          <div className="fr-col-12 fr-col-md-3 fr-pr-md-3w filters">
              <h3>Affinez votre recherche</h3>
              {appliedTag && (
                  <button className="fr-tag fr-tag--dismiss fr-mb-4w"
                          aria-label={`Retirer ${appliedTag}`}
                          onClick={handleTagDeletion}>{appliedTag}</button>
              )}
              <div className="fr-select-group fr-pb-6w">
                  <label className="fr-label" htmlFor="selectRegion">
                      Régions
                  </label>
                  <select value={selectedGeographicalAreaId} onChange={(e) => setSelectedGeographicalAreaId(e.target.value)} className="fr-select" id="select" name="selectRegion">
                      <option value="">Selectionnez une région</option>
                      {getMappedOptions(geographicalAreas, 'id', 'nom')}
                  </select>
                  <label className="fr-label fr-pt-3w" htmlFor="selectAidType">
                      Type d'aide
                  </label>
                  <select value={selectedAidTypeId} onChange={(e) => setSelectedAidTypeId(e.target.value)} className="fr-select" id="select" name="selectAidType">
                      <option value="">Selectionnez un type d'aide</option>
                      {getMappedOptions(aidTypes, 'id', 'nom')}
                  </select>
                  <label className="fr-label fr-pt-3w" htmlFor="selectTopic">
                      Thématique
                  </label>
                  <select value={selectedTopicId} onChange={handleTopicChange} className="fr-select" id="select" name="selectTopic">
                      <option value="">Selectionnez une thématique</option>
                      {getMappedOptions(topics, 'id', 'nom')}
                  </select>
                  {subTopics.length > 0 && (<>
                      <label className="fr-label fr-pt-3w" htmlFor="selectSubTopic">
                          Sous-thématique
                      </label>
                      <select value={selectedSubTopicId} onChange={(e) => setSelectedSubTopicId(e.target.value)} className="fr-select" id="select" name="selectSubTopic">
                          <option value="">Selectionnez une sous-thématique</option>
                          {getMappedOptions(subTopics, 'id', 'nom')}
                      </select>
                  </>)}
                  <label className="fr-label fr-pt-3w" htmlFor="selectProjectStatus">
                      Avancement du projet
                  </label>
                  <select value={selectedProjectStatusId} onChange={(e) => setSelectedProjectStatusId(e.target.value)} className="fr-select" id="select" name="selectProjectStatus">
                      <option value="">Selectionnez un statut</option>
                      {getMappedOptions(projectStatus, 'id', 'nom')}
                  </select>
              </div>
          </div>
          <div className="fr-col-12 fr-col-md-9 fr-pt-3w results">
              { aids.length > 0 && <h2 className="mt-text-align-center color-navy fr-pb-3w">{totalItems} aide{totalItems > 1 ? 's vous sont proposées' : ' vous est proposée'}</h2>}
              { totalItems > 100 && <p className="fr-pb-3w mt-text-align-center">Cela fait beaucoup de choix ! Peut-être avez-vous une thématique en tête pour votre projet ?</p>}
              { getAidsCards()}
              { aids.length > 0 && getPagination()}
          </div>
        </div>
      </div>
    )
}

export default SearchEngine
