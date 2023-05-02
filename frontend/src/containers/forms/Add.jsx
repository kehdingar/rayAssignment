import { Link } from "react-router-dom";
import { useLayoutEffect } from 'react'
import axios from '../../axios';
import { useState, useRef } from "react";
import { useFormik } from 'formik';
import { useNavigate } from 'react-router-dom'

export default function Add() {
    const navigate = useNavigate()
    const [productData, setProductData] = useState(null)
    const mutableData = useRef(null)
    const progressBar = useRef()

    const hiddenInnerSubmitFormRef = useRef(null);
    const [selected, setSelected] = useState("Type Switcher")
    let description = null;
    const products = [];
    const inputFields = []
    const [errors, setErrors] = useState({})

    const baseFormState = {
        sku: "",
        name: "",
        price: "",
        type: ""
    }

    async function getData() {
        try {
            progressBar.current.classList.toggle('hidden')
            const response = await axios.get(`/add-product.php`);
            if (response) {
                progressBar.current.classList.toggle('hidden')
            }
            setProductData(response.data);
            return response.data
        } catch (error) {
            progressBar.current.classList.toggle('hidden')
            return error
        }
    }

    useLayoutEffect(() => {
        getData();
    }, [])

    const { values, handleChange, setValues, handleSubmit, } = useFormik({
        initialValues: baseFormState,
        enableReinitialize: true,
        onSubmit: (values) => {
            onSubmitHandler()
        }
    })

    const onSubmitHandler = async (e) => {
        progressBar.current.classList.toggle('hidden')
        const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json', }
        await axios
            .post(`/process-add-product.php`, values, { headers: headers })
            .then((response) => {
                if (response.data === "success") {
                    progressBar.current.classList.toggle('hidden')
                    return navigate('/home')
                } else {
                    setErrors(response.data.errors)
                    progressBar.current.classList.toggle('hidden')

                }
            })
            .catch((error) => {
                return error

            });
    };

    function spreadArrayValues(arrayData) {
        const spreadedData = {}
        arrayData.forEach(data => {
            spreadedData[data] = ""
        });
        return spreadedData
    }

    const handleExternalButtonClick = (e) => {
        mutableData.current = { ...baseFormState, ...mutableData.current }

        let result = {}
        let availableKeys = Object.keys(values)

        // Compare both objects and get intersected data using keys
        for (let key in mutableData.current) {
            if (availableKeys.includes(key)) {
                result[key] = values[key]
            }
        }
        hiddenInnerSubmitFormRef.current.click();
        setValues({ ...spreadArrayValues(inputFields), ...result })
    }

    function onChangeType(e) {
        handleChange(e)
        setSelected(e.target.value)
    }

    return (
        <div className="top">
            <header>
                <span>Add</span>
                <div class="progress">
                    <div ref={progressBar} className="progress-bar progress-bar-striped progress-bar-animated bg-danger hidden" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="10" style={{ width: "100%" }}>Loading...</div>
                </div>
                <div className="rightMenu">
                    {/* <button class="save button-one">Save</button> */}
                    <Link className="save button-one" type="submit" onClick={handleExternalButtonClick}>Save</Link>
                    <Link to="/home" className="button-two">Cancel</Link>
                </div>
            </header>
            <main>
                <form id="product_form" onSubmit={handleSubmit}>
                    <div className="form-group row">
                        <label className="col-md-1 col-form-label fw-bold">SKU</label>
                        <div className="col-md-4">
                            <input type="text" name="sku" id="sku" value={values.sku} onChange={handleChange} className="form-control" />
                            {errors.sku && <p id="skuError" className="error">{errors.sku}</p>}
                        </div>
                    </div>
                    <div className="form-group row">
                        <label className="col-md-1 col-form-label fw-bold">Name</label>
                        <div className="col-md-4">
                            <input type="text" name="name" id="name" value={values.name} onChange={handleChange} className="form-control" />
                            {errors.name && <p id="skuError" className="error">{errors.name}</p>}
                        </div>
                    </div>
                    <div className="form-group row">
                        <label className="col-md-1 col-form-label fw-bold">Price ($)</label>
                        <div className="col-md-4">
                            <input type="number" name="price" id="price" value={values.price} onChange={handleChange} className="form-control" />
                            {errors.price && <p id="skuError" className="error">{errors.price}</p>}
                        </div>
                    </div>

                    {
                        // Render Switch-Type only when data from API is available
                        productData !== null &&
                        <div>
                            <div className="input-group mb-8">
                                <div className="input-group-prepend">
                                    <label className="input-group-text fw-bold" htmlFor="productType">Type Switcher</label>
                                </div>
                                <div className="col-md-4">
                                    <select className="custom-select form-control mb-4" id="productType" name="type" value={values.type} onChange={(e) => { onChangeType(e) }}>
                                        <option value="" >{"Type Switcher"} </option>
                                        {
                                            productData.map((product, index) => {
                                                products.push(Object.keys(product)[0])
                                                return <option value={Object.keys(product)[0]} key={index}>{product[Object.keys(product)[0]].displayName}</option>
                                            })
                                        }
                                    </select>
                                    {errors.type && <p id="skuError" className="error">{errors.type}</p>}
                                </div>
                            </div>
                            {
                                <>
                                    {
                                        productData.map((product) => {
                                            if (Object.keys(product)[0] === selected) {
                                                description = product[selected]['message']
                                                return (
                                                    product[selected].formfields.map((field, index) => {
                                                        //input fields to be added to initialValues
                                                        mutableData.current = { ...mutableData.current, [Object.keys(field)[0]]: "" }
                                                        inputFields.push(Object.keys(field)[0])
                                                        return (
                                                            <div key={index} className="form-group row ">
                                                                <label className="col-md-1 col-form-label fw-bold" style={{ textTransform: 'capitalize' }}>{Object.keys(field)[0]} <span style={{ fontSize: '11px' }}>{"("}{field[Object.keys(field)[0]].unit}{")"}</span></label>
                                                                <div className="col-md-4">
                                                                    <input className="form-control dynamic" type={field[Object.keys(field)[0]].type} id={Object.keys(field)[0]}  name={Object.keys(field)[0]} value={values[Object.keys(field)[0]] || ""} onChange={handleChange} />
                                                                    {errors[Object.keys(field)[0]] && <p id="skuError" className="error">{errors[Object.keys(field)[0]]}</p>}
                                                                </div>

                                                            </div>
                                                        )
                                                    })
                                                )
                                            }
                                            return null
                                        })
                                    }
                                </>
                            }
                            <p className="fw-bold">{description}</p>
                        </div>
                    }

                    <div id="productHTML">
                    </div>
                    <small id="productInfo" style={{ fontWeight: 'bold' }}></small>
                    <button type="submit" ref={hiddenInnerSubmitFormRef} className="hidden"></button>
                </form>
            </main>
        </div>
    )
}