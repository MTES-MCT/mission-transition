import React from "react";
import Aid from "./Aid";

const AidList = ({aids, perimeterName}) => {

    if (aids.length === 0) {
        return (<></>);
    }

    return (
        <>
            <hr/>
            <h3 className="fr-pt-3w">
                Nous avons <span className="highlighted">{ aids.length }</span> dispositif(s) en {perimeterName}
            </h3>
            <div className="card-aid-list fr-py-5w">
                {aids.map((aid, i) => <Aid aid={aid} last={i === (aids.length + 1)}/>)}
            </div>
        </>
    )
}

export default AidList
