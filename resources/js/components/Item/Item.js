import React, { useState } from 'react';
import { Modal, OverlayTrigger, Tooltip } from 'react-bootstrap';
import ItemDetails from "./ItemDetails";
import axios from 'axios'
import Excludes from "./Excludes";

const styles = {
    'imgSize' : {'maxWidth': '180px'},
'cover' : {
    'width': '180px',
    'objectFit': 'cover'
    }
};
// make a red highlight of the title or condition contain "Part" keyword
const checkRedKeyword = (txt) => {
    let regex = /(PART|FAULT)+/
    return regex.test(txt.toUpperCase());
}



const Item = (props) => {
    const [open, setOpen] = useState(false);
    const [blacklistTxt, setBlacklistTxt] = useState('Put item to blacklist');
    const [successBlacklist, setSuccessBlacklist] = useState('btn-info');
    const [show, setShow] = useState(false);
    const [sellerExcludeTxt, setSellerExcludeTxt] = useState('Blacklist seller');

    const [successSellerBlacklist, setSuccessSelleerBlacklist] = useState('btn-info');
    const [undoSeller, setUndoSeller] = useState(false);

    const [categoryStatus, setCategoryStatus] = useState('btn-outline-info')
    const [categoryStatusTxtDanger, setCategoryStatusTxtDanger] = useState('')





    //function
    const blacklistCategory = (category, title) => {
        axios.post('/api/category/blacklist', {category, title})
        .then((res) => setCategoryStatus('btn-outline-success'))
        .catch((err) => setCategoryStatusTxtDanger('this category already in blacklist'))

    }

    const blackList = (title) => {
        setBlacklistTxt('Loading....');
        axios.post('/api/items/blacklist', {data: title})
            .then((res) =>
            {
                setBlacklistTxt('Success');
                setSuccessBlacklist('btn-success');
                setUndoSeller(true);
            })
            .catch((error => {
                console.log(error)
                setBlacklistTxt('Item already in blacklist');
                setSuccessBlacklist('btn-danger');
            }))
    };

    const removeBlacklist = (name) => {
        setSellerExcludeTxt('Loading...');
        axios.delete('/api/seller/blacklist', {data: name})
            .then((res) =>
            {
                setSellerExcludeTxt('Put seller to blacklist');
                setSuccessSelleerBlacklist('btn-info');
                setUndoSeller(name);
                console.log(res)
            })
            .catch((error => {
                setSellerExcludeTxt('Put seller to blacklist');
                setSuccessSelleerBlacklist('btn-info');
                console.log(error)
            }))
    }

    const sellerBlacklist = (name) =>
    {
        setSellerExcludeTxt('Loading...');
      axios.post('/api/seller/blacklist', {data: name})
          .then((res) =>
          {
              setSellerExcludeTxt('Success');
              setSuccessSelleerBlacklist('btn-success');
              setUndoSeller(name)
          })
          .catch((error => {
              setSellerExcludeTxt('Put seller to blacklist');
              setSuccessSelleerBlacklist('btn-info');

              if(undoSeller) {
                  removeBlacklist(undoSeller);
              }
          }))
    };
    //----------------------//

    const {category,feedbackPercent, feedbackScore, title, picture, price, from_site, item_condition, shipping_cost, id, newItem, seller } = props.item;
    const displayPrice = from_site === 'EBAY-AU' ? 'AU $'+price : '$'+price;
    const ebayItemURL = 'https://www.ebay.com' + (from_site === 'EBAY-AU' ? '.au' : '') + '/itm/'+ id;
    return (
        <div className="card m-4 item"

             onMouseLeave={() => setOpen(false)
             }
        >
            <div className="card-body d-xl-flex">

                <div className="mr-3"
                     style={styles.cover}
                >
                    <img alt={title} src={picture}
                         className="img-responsive"
                    />
                </div>
                <div
                  >
                    <a target="_blank" href={ebayItemURL} className={checkRedKeyword(title) ? "text-danger" : "title"}>{title}</a>
                    <h3>{displayPrice}</h3>

                    <p className="grey-word">Shipping: {shipping_cost}</p>
                    <h4 className={checkRedKeyword(item_condition) ? "text-danger" : ""}>{item_condition}</h4>
                    <p>{from_site}</p>
                    <p>Seller: {seller} (<span className="text-primary">{feedbackScore}</span>)</p>
                    <p>{feedbackPercent}% Positive feedback </p>
                    <OverlayTrigger
                    placement={'left'}

                    overlay={
                        <Tooltip id={'tooltip-left'}>
                            Click me to blacklist this category
                        </Tooltip>
                    }
                    >
                    <button
                    onClick={() => blacklistCategory(category, title)}
                    className={`btn font-weight-bold btn-sm ${categoryStatus}`}>Category: {category}</button>
                    </OverlayTrigger>
                    {/*<p>Index: {props.index}</p>*/}
                    <span style={{ 'fontWeight': 'bold;' }} className="ml-1 text-danger">{categoryStatusTxtDanger}</span>

                </div>
                <div className="ml-auto d-flex flex-column">



                    {/* <button target="_blank"
                       className={"float-right btn text-white mt-4 " + successBlacklist}
                        onClick={
                            // () => setShow(true)
                            () => blackList(title)
                        }

                    >{blacklistTxt}</button> */}
                    {/*<Excludes*/}
                    {/*    title={title}*/}
                    {/*   blacklist={blackList}*/}
                    {/*    show={show}*/}
                    {/*    setShow={setShow}*/}
                    {/*/>*/}

                    <button className={'float-right btn text-white mt-4 ' +successSellerBlacklist}
                            onClick={() => sellerBlacklist(seller)}
                    >
                        {sellerExcludeTxt}
                    </button>

                    <button className={'btn btn-primary mt-4'}
                            onClick={() => {setOpen(!open); props.setSeen(props.index);}
                            }
                    >Show Details</button>

                    { newItem ? <h1 className='text-success'>New</h1> : ''}
                    {open ? <ItemDetails id={id} /> : ''}
                </div>
            </div>
        </div>

    )
}


export default Item
