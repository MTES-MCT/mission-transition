import React, { useState, useEffect } from "react";
import ReactDOM from 'react-dom'
import AidSearchEngineFilters from "./AidSearchEngineFilters";
import AidList from './AidList'
import {fetchAids} from "./Api";

const AidSearchEngine = () => {
    const [environmentalTopicCategory, setEnvironmentalTopicCategory] = useState(null);
    const [environmentalTopics, setEnvironmentalTopics] = useState([]);
    const [environmentalTopicSelected, setEnvironmentalTopicSelected] = useState(null);
    const [aidTypes, setAidTypes] = useState([]);
    const [region, setRegion] = useState(null);
    const [aids, setAids] = useState([]);
    const [filteredAids, setFilteredAids] = useState([]);
    const [isSearching, setIsSearching] = useState(false);
    const [hasTopicError, setHasTopicError] = useState(false);
    const [hasSearchError, setHasSearchError] = useState(false);
    const [searchValue, setSearchValue] = useState('');
    const [lastSearchHistory, setLastSearchHistory] = useState({})

    const handleSubmit = (e) => {
        e.preventDefault();
        setHasTopicError(environmentalTopicCategory === null && searchValue === '');
        setHasSearchError(searchValue === '' && environmentalTopicCategory === null);

        if (environmentalTopicCategory !== null || searchValue !== '') {
            fetchAids(environmentalTopicCategory, aidTypes, region, environmentalTopicSelected, searchValue)
                .then(data => {
                    setAids(data);
                    setFilteredAids(data);
                })
            setIsSearching(true);
            setLastSearchHistory({
                topic: environmentalTopicSelected,
                category: environmentalTopicCategory,
                aidTypes: aidTypes,
                region: region
            })
        }
    };

    return (
        <>
            <AidSearchEngineFilters
                aids={aids}
                setAids={setAids}
                setFilteredAids={setFilteredAids}
                environmentalTopics={environmentalTopics}
                setEnvironmentalTopics={setEnvironmentalTopics}
                setAidTypes={setAidTypes}
                setRegions={setRegion}
                handleSubmit={handleSubmit}
                isSearching={isSearching}
                hasTopicError={hasTopicError}
                setEnvironmentalTopicCategory={setEnvironmentalTopicCategory}
                setEnvironmentalTopicSelected={setEnvironmentalTopicSelected}
                environmentalTopicSelected={environmentalTopicSelected}
                searchValue={searchValue}
                setSearchValue={setSearchValue}
                hasSearchError={hasSearchError}
            />
            {!isSearching && (
                <div className="bg-light no-results fr-p-12w">
                    <img alt="lancez-vous" className="mt-w100" src="/build/img/search_default.svg" />
                    <div className="text fr-pt-3w">
                        <p className="fr-pb-3w">Veuillez sélectionner un objectif dans les filtres
                            afin d’avoir des résultats de recherche.
                        </p>
                    </div>
                </div>
            )}
            {isSearching && filteredAids.length && (
                <div className="bg-light">
                    <div className="fr-container fr-pt-7w">
                        <>
                            <AidList
                                aids={filteredAids.filter(aid => aid.perimeter === 'NATIONAL')}
                                perimeterName={'au niveau national'}
                                lastSearchHistory={lastSearchHistory}
                            />
                            <AidList
                                aids={filteredAids.filter(aid => aid.perimeter === 'REGIONAL')}
                                perimeterName={'au niveau régional'}
                                lastSearchHistory={lastSearchHistory}
                            />
                        </>
                    </div>
                </div>
            )}
            {isSearching && !filteredAids.length && (
                <div className="bg-light no-results fr-p-12w">
                    <img src="/build/img/no_results.svg" alt="Pas de résultat" />
                        <div className="text fr-pt-3w">
                            <p className="fr-pb-3w">Notre base de données des aides n’est pas encore complète.</p>
                            <p><b>Relancez une recherche avec d’autres critères pour trouver des résultats.</b></p>
                        </div>
                </div>
            )}
        </>
    )
}

export default AidSearchEngine
