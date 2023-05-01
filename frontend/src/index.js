import React from 'react';
import './index.css';
import { createRoot } from "react-dom/client";
import { createBrowserRouter, RouterProvider, Link,} from "react-router-dom";
import Add from './containers/forms/Add';
import Home from './containers/home/Home';
import Footer from './containers/footer/Footer'
import { Provider } from "react-redux";
import { store } from "./redux/store"


function AppLayout({children}){
 return (
   <Provider store={store}>
      <div className='wrap'>
          {children}
        <Footer />
      </div>
    </Provider>   
  )
}

function ErrorPage() {
  return (
      <div className='errorPage'>
        <h1>Oops! Nothing found</h1>
        <p>See products <Link to="/home"><span className="text-underline">Here</span></Link></p>
      </div>
  )
}

const router = createBrowserRouter([
  {
    path: "/",
    element:
    <AppLayout>
          <Home />
        </AppLayout>,
    },
    {
    path: "/home",
    element:
    <AppLayout>
          <Home />
      </AppLayout>,
    },
    {
      path: "/add",
      element:
      <AppLayout>
          <Add />
        </AppLayout>,
    },
 
    {
      path: "*",
      element:<ErrorPage/>
    },
  ]

);

createRoot(document.getElementById("root")).render(
  <>
  <RouterProvider router={router} />
  </>
);