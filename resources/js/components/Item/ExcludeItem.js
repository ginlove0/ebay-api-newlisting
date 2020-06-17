import React,{useState} from 'react'
import {Button} from "react-bootstrap";
const ExcludeItem = (props) => {
    const [select, setSelect] = useState(false);
    return(
        <Button
            className="m-1"
            variant={select ? 'danger' : 'primary'}
            onClick={() => {
                props.selectWord(props.index);
                setSelect(!select);
            }}
        >{props.word}</Button>
    )
}

export default ExcludeItem
