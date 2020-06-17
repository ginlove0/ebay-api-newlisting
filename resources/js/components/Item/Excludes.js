import React, {Component} from 'react'
import { Modal, Button } from 'react-bootstrap'
import ExcludeItem from "./ExcludeItem";
class Excludes extends Component {
    constructor(props)
    {
        super(props);
        this.renderWords = this.renderWords.bind(this);
        this.selectWord = this.selectWord.bind(this);
        this.state = {
            words: [{}]
        }
    }

    selectWord(index){

        let copyWords = this.state.words;
        copyWords[index]
    }

    componentDidMount() {
        var words = this.props.title.split(' ');
        this.setState({
            words: [
                ...words
            ]
        });
    }

    renderWords(){


        return this.state.words.map((word,index) => (
            <ExcludeItem
                key={index}
                selectWord={this.selectWord}
                word={word}
            />
        ))
    }

    render() {
        return(
            <Modal show={this.props.show} onHide={() => this.props.setShow(false)}>

                    <Modal.Header closeButton>
                        <Modal.Title>Please select the words or seller that not important to blackist</Modal.Title>
                    </Modal.Header>

                    <Modal.Body>
                        {this.renderWords()}
                    </Modal.Body>

                    <Modal.Footer>
                        <Button variant="secondary" onClick={() => this.props.setShow(false)} >Close</Button>
                        <Button variant="primary">Save changes</Button>
                    </Modal.Footer>

            </Modal>
        )
    }
}
export default Excludes
