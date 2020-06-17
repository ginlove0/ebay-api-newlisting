import React, {Component} from 'react'
import { bounce, fadeIn } from 'react-animations';
import Radium, {StyleRoot} from 'radium';
import axios from 'axios'
import ReactHtmlParser, { processNodes, convertNodeToElement, htmlparser2 } from 'react-html-parser';


const styles = {
    bounce: {
        animation: 'x 0.5s',
        animationName: Radium.keyframes(fadeIn, 'fadeIn')
    }
};

class ItemDetails extends Component {
    constructor(props){
        super(props);


        this.state = {
            details: {
                'Description': '<div class="spinner-border" role="status">\n' +
                    '  <span class="sr-only">Loading...</span>\n' +
                    '</div>'
            }
        }

    }

    componentDidMount() {
        axios.get('/api/items/'+this.props.id+'/')
            .then((res) => {
               this.setState({
                   details: res.data.Item
               })
            })
            .catch((error => console.log(error)))
    }

    render() {
        const {Description, ConditionDescription} = this.state.details;
        return (
            <StyleRoot className='card detail-display-position' style={styles.bounce}>

                <div className="card-body">
                    {ConditionDescription ?
                        <p><span className="font-weight-bolder big-font">Condition Description: </span>{ConditionDescription}</p>
                        : ''  }
                    <div className='container d-flex justify-content-center'>
                    { ReactHtmlParser(Description) }
                    </div>
                </div>

            </StyleRoot>
        )
    }
};

export default ItemDetails;
