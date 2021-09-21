import React from "react";
import Aid from "./Aid";

const AidList = ({aids, perimeterName, lastSearchHistory}) => {

    if (aids.length === 0) {
        return (<></>);
    }

    return (
        <>
            <h3 className="fr-pt-3w">
                <span className="highlighted--dark subtitle">{ aids.length } résultats {perimeterName ?? perimeterName} pour </span>
            </h3>
            <ul className="fr-tags-group">
                {lastSearchHistory.category && <li className={'fr-pr-1w'}><span className="mt-tag subtitle">{lastSearchHistory.category.label}</span></li>}
                {lastSearchHistory.topic && <li className={'fr-pr-1w'}><span className="mt-tag subtitle">{lastSearchHistory.topic.label}</span></li>}
                {lastSearchHistory.aidTypes.map(type => <li className={'fr-pr-1w'}><span className="mt-tag subtitle">{type.label}</span></li>)}
                {lastSearchHistory.aidTypes.length === 0 && <><li className={'fr-pr-1w'}><span className="mt-tag subtitle">Aide en ingénierie</span></li><li className={'fr-pr-1w'}><span className="mt-tag subtitle">Aide financière</span></li></>}
                {lastSearchHistory.region && <li className={'fr-pr-1w'}><span className="mt-tag subtitle">{lastSearchHistory.region.label}</span></li>}
            </ul>
            <hr/>
            <div className="card-aid-list fr-py-5w">
                {aids.map((aid, i) => <Aid aid={aid} last={i === (aids.length + 1)}/>)}
            </div>
        </>
    )
}

export default AidList
