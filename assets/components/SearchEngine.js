import React, { useState, useEffect } from "react";
import {
    fetchAids,
    fetchGeographicalAreas,
    fetchAidTypes,
    fetchProjectStatus,
    fetchTopics} from "./Api";

const SearchEngine = () => {
    const [aids, setAids] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    // Pagination
    const [totalItems, setTotalItems] = useState(true);
    const [firstPagePath, setFirstPagePath] = useState(undefined);
    const [lastPagePath, setLastPagePath] = useState(undefined);
    const [previousPagePath, setPreviousPagePath] = useState(undefined);
    const [nextPagePath, setNextPagePath] = useState(undefined);
    const [currentPagePath, setCurrentPagePath] = useState('/api/aides?itemsPerPage=10&page=1');
    const [currentPageNumber, setCurrentPageNumber] = useState(1);
    const [lastPageNumber, setLastPageNumber] = useState(1);

    // Filters options
    const [geographicalAreas, setGeographicalAreas] = useState([]);
    const [aidTypes, setAidTypes] = useState([]);
    const [projectStatus, setProjectStatus] = useState([]);
    const [topics, setTopics] = useState([]);
    const [subTopics, setSubTopics] = useState([]);

    // Selected Filters
    const [selectedGeographicalAreaId, setSelectedGeographicalAreaId] = useState('');
    const [selectedAidTypeId, setSelectedAidTypeId] = useState('');
    const [selectedProjectStatusId, setSelectedProjectStatusId] = useState('');
    const [selectedTopic, setSelectedTopic] = useState({id: ''});
    const [selectedSubTopicId, setSelectedSubTopicId] = useState('');

    useEffect(async() => {
        setGeographicalAreas(await fetchGeographicalAreas())
        setAidTypes(await fetchAidTypes())
        setProjectStatus(await fetchProjectStatus())
        setTopics(await fetchTopics())
    }, [])

    useEffect(async() => {
        setIsLoading(true);
        let response = await fetchAids(
            selectedGeographicalAreaId,
            selectedAidTypeId,
            selectedProjectStatusId,
            selectedSubTopicId,
            currentPagePath
        );
        setTotalItems(response['hydra:totalItems']);
        setFirstPagePath(response['hydra:view']['hydra:first']);
        setLastPagePath(response['hydra:view']['hydra:last']);
        if (response['hydra:view']['hydra:last'] !== undefined) {
            setLastPageNumber(parseInt((response['hydra:view']['hydra:last']).slice(-1)));
        } else {
            setLastPageNumber(1);
        }
        setPreviousPagePath(response['hydra:view']['hydra:previous']);
        setNextPagePath(response['hydra:view']['hydra:next'])
        setCurrentPageNumber(parseInt(currentPagePath.slice(-1)))
        setAids(response['hydra:member']);
        setIsLoading(false);
    }, [selectedGeographicalAreaId, selectedAidTypeId, selectedProjectStatusId, selectedSubTopicId, currentPagePath]);


    const getAidsCards = () => {
        if (isLoading) {
            return <div className="fr-grid-row fr-grid-row--center">
                <div className="fr-col-12 mt-text-align-center">
                    <img src="build/img/illu4.svg" alt="Recherche en cours"/>
                </div>
                <div className="fr-col-12 fr-pt-5w mt-text-align-center">
                    <h2 className="color-navy">Un instant, nous recherchons les aides disponibles...</h2>
                </div>
            </div>
        }

        if (aids.length === 0) {
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

        return aids.map(aid => <div className="fr-card fr-enlarge-link fr-card--horizontal fr-card--lg fr-mb-3w">
            <div className="fr-card__body" key={aid.id}>
                <div className="fr-card__content">
                    <h4 className="fr-card__title">
                        <a href={"/recherche/dispositif/" + aid.slug}>{aid.nomAideNormalise}</a>
                    </h4>
                    {/*<p className="fr-card__desc">{aid.description}</p>*/}
                    <div className="fr-card__start">
                        <p className="fr-card__detail fr-icon-warning-fill"></p>
                    </div>
                    <div className="fr-card__end">
                        <p className="fr-card__detail fr-icon-warning-fill">Proposé par {aid.porteursAide.join(', ')}</p>
                    </div>
                </div>
            </div>
        </div>)
    }

    const onPaginationClick = (newPath) => {
        if (newPath === undefined) {
            return false;
        }

        setCurrentPagePath(newPath);
    }

    const getPagination = () => {
        return <nav role="navigation" className="fr-pagination" aria-label="Pagination">
            <ul className="fr-pagination__list">
                <li>
                    <a className="fr-pagination__link fr-pagination__link--first" href={currentPageNumber === 1 ? undefined : '#'} onClick={e => onPaginationClick(firstPagePath)} aria-disabled={currentPageNumber === 1} role="link">
                        Première page
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link fr-pagination__link--prev fr-pagination__link--lg-label"
                       aria-disabled={currentPageNumber === 1} href={currentPageNumber === 1 ? undefined : '#'} role="link" onClick={e => onPaginationClick(previousPagePath)}>
                        Page précédente
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link" aria-current="page" title={"Page" + currentPageNumber}>
                        {currentPageNumber}
                    </a>
                </li>
                {/*<li>*/}
                {/*    <a className="fr-pagination__link" href="#" title="Page 2">*/}
                {/*        2*/}
                {/*    </a>*/}
                {/*</li>*/}
                {/*<li>*/}
                {/*    <a className="fr-pagination__link fr-displayed-lg" href="#" title="Page 3">*/}
                {/*        3*/}
                {/*    </a>*/}
                {/*</li>*/}
                {/*<li>*/}
                {/*    <a className="fr-pagination__link fr-displayed-lg">*/}
                {/*        …*/}
                {/*    </a>*/}
                {/*</li>*/}
                {/*<li>*/}
                {/*    <a className="fr-pagination__link fr-displayed-lg" href="#" title="Page 130">*/}
                {/*        130*/}
                {/*    </a>*/}
                {/*</li>*/}
                {/*<li>*/}
                {/*    <a className="fr-pagination__link fr-displayed-lg" href="#" title="Page 131">*/}
                {/*        131*/}
                {/*    </a>*/}
                {/*</li>*/}
                {/*<li>*/}
                {/*    <a className="fr-pagination__link" href="#" title="Page 132">*/}
                {/*        132*/}
                {/*    </a>*/}
                {/*</li>*/}
                <li>
                    <a className="fr-pagination__link fr-pagination__link--next fr-pagination__link--lg-label" href={currentPageNumber === lastPageNumber ? undefined : '#'}
                       aria-disabled={currentPageNumber === lastPageNumber} role="link" onClick={e => onPaginationClick(nextPagePath)}>
                        Page suivante
                    </a>
                </li>
                <li>
                    <a className="fr-pagination__link fr-pagination__link--last" onClick={e => onPaginationClick(lastPagePath)} href={currentPageNumber === lastPageNumber ? undefined : '#'}
                       aria-disabled={currentPageNumber === lastPageNumber} role="link">
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
        const selectedTopic = topics.find(t => t.id === parseInt(e.target.value));

        if (selectedTopic) {
            setSelectedTopic(selectedTopic);
            setSubTopics(selectedTopic.sousThematique)
        }
    }

    return (
      <div className="fr-container">
        <div className="fr-grid-row fr-grid-row--center fr-pt-8w fr-pb-3w fr-pb-md-8w">
          RECHERCHE
        </div>
        <div className="fr-grid-row">
          <div className="fr-col-12 fr-col-md-3 fr-pr-3w filters">
              <h3>Affinez votre recherche</h3>
              <div className="fr-select-group">
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
                  <select value={selectedTopic.id} onChange={handleTopicChange} className="fr-select" id="select" name="selectTopic">
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
          <div className="fr-col-12 fr-col-md-9 results">
              { aids.length > 0 && <h2 className="mt-text-align-center color-navy fr-pb-3w">{totalItems} aides vous sont proposées</h2>}
              { aids.length > 100 && <p className="fr-pb-3w">Cela fait beaucoup de choix ! Peut-être avez-vous une thématique en tête pour votre projet ?</p>}
              { getAidsCards()}
              { aids.length > 0 && getPagination()}
          </div>
        </div>
      </div>
    )
}

export default SearchEngine
