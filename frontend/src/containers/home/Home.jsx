import { Link, } from "react-router-dom";
import Product from "../product/Product";
import axios from '../../axios';
import { useEffect } from 'react'
import { useDispatch } from "react-redux";
import { SET_INITIAL_STATE } from "../../redux/actions";
import { useSelector } from "react-redux"
import { useRef } from "react";

export default function Home() {

    const dispatch = useDispatch();
    const progressBar = useRef()

    const { products } = useSelector((state) => {
        return {
            products: state.products
        }
    })

    async function getProducts() {
        progressBar.current.classList.toggle('hidden')
        try {
            const response = await axios.get("/list-products.php");
            progressBar.current.classList.toggle('hidden')

            const modifiedProducts = response.data['products'].map((product) => {
                product['isChecked'] = false
                return product
            })

            const databaseState = { products: modifiedProducts }

            dispatch({
                type: SET_INITIAL_STATE,
                payload: {
                    initialState: databaseState,
                }
            });

        } catch (error) {
            console.log("ERROR HERE")
            progressBar.current.classList.toggle('hidden')
            console.log(error)
            return error
        }
    }

    useEffect(() => {
        getProducts();
        // eslint-disable-next-line
    }, [])

    const handleExternalButtonClick = async () => {
        const selected = []
        products.forEach(product => {
            if (product.isChecked === true) {
                selected.push(product.id)
            }
        });

        const updatedProductList = products.filter((product) => {
            if (!selected.includes(product.id)) {
                return product
            } else {
                return null
            }
        })

        dispatch({
            type: SET_INITIAL_STATE,
            payload: {
                initialState: { products: updatedProductList },
            }
        });

        const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json', }
        await axios
            .post(`/process-delete.php`, selected, { headers: headers })
            .then((response) => {
                return response
            })
            .catch((error) => {
                return error

            });
    }

    return (
        <div className="top">
            <header>
                <span>Product List</span>
                <div class="progress">
                    <div ref={progressBar} className="progress-bar progress-bar-striped progress-bar-animated bg-danger hidden" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="10" style={{ width: "100%" }}>Loading...</div>
                </div>
                <div className="rightMenu">
                    <Link to="/add" className="update button-one">ADD</Link>
                    <Link className="mass-delete button-two delete-product-btn" onClick={handleExternalButtonClick}>MASS DELETE</Link>
                </div>
            </header>
            <main>
                <form id="productListForm" >
                    <Product />
                </form>
            </main>
        </div>
    )
}