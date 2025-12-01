import React, { useState, useEffect } from "react";
import axios from "axios";

import Navbar from "./Navbar";
import Hero from "./Hero";
import Services from "./Services";
import BookingForm from "./BookingForm";
import Tracking from "./Tracking";
import Dashboard from "./Dashboard";
import Footer from "./Footer";

const UserPage = () => {
    const [isGlass, setIsGlass] = useState(false);

    const [services, setServices] = useState([]);
    const [userData, setUserData] = useState(null);
    const [latestOrder, setLatestOrder] = useState(null);
    const [isLoggedIn, setIsLoggedIn] = useState(false);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const res = await axios.get("/api/landing-data");

                console.log("CEK LOGIN:", res.data.is_logged_in);

                setServices(res.data.services);
                setUserData(res.data.user);
                setLatestOrder(res.data.latest_order);

                // Set Status Login
                setIsLoggedIn(res.data.is_logged_in);
            } catch (error) {
                console.error("Gagal fetch data:", error);
            } finally {
                setLoading(false);
            }
        };
        fetchData();
    }, []);

    if (loading)
        return (
            <div className="h-screen flex items-center justify-center text-slate-500">
                Loading...
            </div>
        );

    return (
        <div
            className={`w-full font-sans transition-colors duration-500 relative overflow-x-hidden ${
                isGlass
                    ? "bg-slate-900 text-white"
                    : "bg-secondary text-slate-800"
            }`}
        >
            {isGlass && <div className="fixed inset-0 bg-slate-900 z-0"></div>}
            <div className="fixed bottom-6 right-6 z-50">
                <button
                    onClick={() => setIsGlass(!isGlass)}
                    className="bg-white px-4 py-2 rounded-full shadow text-xs font-bold text-blue-900"
                >
                    {isGlass ? "Mode Normal" : "Mode Glass"}
                </button>
            </div>

            <Navbar
                isGlass={isGlass}
                isLoggedIn={isLoggedIn}
                userName={userData?.name}
            />

            <Hero isGlass={isGlass} />
            <Services isGlass={isGlass} servicesData={services} />
            <BookingForm
                isGlass={isGlass}
                servicesData={services}
                user={userData}
            />

            {isLoggedIn ? (
                <div className="animate-fade-in">
                    <Tracking isGlass={isGlass} order={latestOrder} />
                    <Dashboard isGlass={isGlass} user={userData} />
                </div>
            ) : (
                <section
                    className={`py-24 text-center flex flex-col items-center justify-center transition-colors duration-500 ${
                        isGlass ? "bg-white/5" : "bg-white"
                    }`}
                >
                    <h2
                        className={`text-3xl font-bold mb-4 ${
                            isGlass ? "text-white" : "text-slate-800"
                        }`}
                    >
                        Pantau Cucianmu Sekarang
                    </h2>
                    <p
                        className={`mb-8 ${
                            isGlass ? "text-blue-200" : "text-slate-500"
                        }`}
                    >
                        Login untuk melihat Tracking dan Dashboard Pelanggan
                    </p>
                    <a
                        href="/login"
                        className="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:scale-105 transition"
                    >
                        Login Sekarang
                    </a>
                </section>
            )}

            <Footer isGlass={isGlass} />
        </div>
    );
};

export default UserPage;
