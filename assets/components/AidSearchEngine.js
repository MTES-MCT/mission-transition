import React, { useState, useEffect } from "react";
import ReactDOM from 'react-dom'
import AidSearchEngineFilters from "./AidSearchEngineFilters";
import AidList from './AidList'
import {fetchAids} from "./Api";

const AidSearchEngine = () => {
    const [environmentalTopicCategory, setEnvironmentalTopicCategory] = useState([]);
    const [environmentalTopics, setEnvironmentalTopics] = useState([]);
    const [aidTypes, setAidTypes] = useState([]);
    const [regions, setRegions] = useState([]);
    const [aids, setAids] = useState([]);
    const [filteredAids, setFilteredAids] = useState([]);
    const [isSearching, setIsSearching] = useState(false);
    const [hasTopicError, setHasTopicError] = useState(false);
    const [hasTypeError, setHasTypeError] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        setHasTopicError(environmentalTopicCategory.length === 0);
        setHasTypeError(aidTypes.length === 0);

        if (environmentalTopicCategory.length !== 0 && aidTypes.length !== 0) {
            fetchAids(environmentalTopicCategory, aidTypes, regions)
                .then(data => {
                    setAids(data);
                    setFilteredAids(data);
                })
            setIsSearching(true);
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
                setRegions={setRegions}
                handleSubmit={handleSubmit}
                isSearching={isSearching}
                hasTopicError={hasTopicError}
                hasTypeError={hasTypeError}
                setEnvironmentalTopicCategory={setEnvironmentalTopicCategory}
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
            {isSearching && !filteredAids.length && (
                <div className="bg-light no-results fr-p-12w">
                    <img src="/build/img/no_results.svg" alt="Pas de résultat" />
                        <div className="text fr-pt-3w">
                            <p className="fr-pb-3w">Notre base de données des aides n’est pas encore complète.</p>
                            <p><b>Relancez une recherche avec d’autres critères pour trouver des résultats.</b></p>
                        </div>
                </div>
            )}
            {isSearching && filteredAids.length && (
                <div className="bg-light">
                    <div className="fr-container fr-pt-7w">
                        <p className="subtitle">{filteredAids.length} dispositif(s) correspondent à votre recherche</p>
                        <AidList
                            aids={filteredAids.filter(aid => aid.perimeter === 'REGIONAL')}
                            perimeterName={'région'}
                        />
                        <AidList
                            aids={filteredAids.filter(aid => aid.perimeter === 'NATIONAL')}
                            perimeterName={'France'}
                        />
                    </div>
                </div>
            )}
        </>
    )
}

export default AidSearchEngine
