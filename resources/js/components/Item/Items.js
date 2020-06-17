import React, {Component} from 'react';
import Item from "./Item";
import axios from 'axios';
import Pusher from "pusher-js";
import { connect } from 'react-redux'
import {api_items_index, pusher_items, setSeen} from '../../store/actions/itemsAction'

class Items extends Component {
    constructor (props) {
        super(props);
        this.state = {
            items: [{ newItem: false}]
        }
        this.handlePusher = this.handlePusher.bind(this);
        this.playSound = this.playSound.bind(this);
        this.setSeen = this.setSeen.bind(this);
        this.loading = this.loading.bind(this);
    }

    setSeen(index) {
        // let copyItems = this.props.items;
        //         // copyItems[index].newItem = false;
        //         // this.setState({
        //         //         items: copyItems
        //         // });
    }




    playSound() {
        let sound = document.getElementById('myAudio');
        sound.load();
        sound.play();
        if (sound !== undefined) {
            sound.then(() => {
                sound.play();

            }).catch(error => {
                // Autoplay was prevented.
                // Show a "Play" button so that user can start playback.
            });
        }
    }

    handlePusher() {
        // const username = window.prompt('Username: ', 'Anonymous');
        // this.setState({username});
        // Pusher.logToConsole = true;
        const {pusher_items} = this.props;
        const pusher = new Pusher('b81b4e05760789c1850f', {
            cluster: 'ap4',
            encrypted: true
        });
        const channel = pusher.subscribe('my-channel');
        channel.bind('App\\Events\\MessagePushed', data => {
            // const [open, setOpen] = useState(false);
            // const [blacklistTxt, setBlacklistTxt] = useState('Put item to blacklist');
            // const [successBlacklist, setSuccessBlacklist] = useState('btn-info');
            // const [show, setShow] = useState(false);
            // const [sellerExcludeTxt, setSellerExcludeTxt] = useState('Put seller to blacklist');
            //
            // const [successSellerBlacklist, setSuccessSelleerBlacklist] = useState('btn-info');
            // const [undoSeller, setUndoSeller] = useState(false);
            if(data.data) {
            pusher_items({
                ...data.data,
                newItem: true,
            });

            this.playSound();
            }
        });
    }


    componentDidMount() {

        this.props.api_items_index();
        let items = this.props.items;
        this.handlePusher();
    }

    loading() {
        return(
            <div className="container justify-content-center align-self-center d-flex mt-5">
            <div className="spinner-border" role="status">
                <span className="sr-only">Loading...</span>
            </div>
            </div>
        )
    }


    render() {
        const { items, pushItem } = this.props;

        return(
            <div>

                {
                    items.length > 1 ?
                    items.map((item,index) => (
                        <Item
                        key={item.id}
                        item={item}
                        index={index}
                        setSeen={this.props.setSeen}
                        />
                    )) : this.loading()
                }


            </div>
        )
    }
}

const mapStateToProps = state => (
    {
        items: state.itemsReducer.items,
    }
);

const mapActionsToProps = {
    api_items_index,
    pusher_items,
    setSeen
};


export default connect(mapStateToProps,mapActionsToProps)(Items)
