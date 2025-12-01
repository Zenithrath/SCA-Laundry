import React from "react";
import { motion } from "framer-motion";

const SectionWrapper = ({ children, className, id, noSnap, isGlass }) => (
    <motion.section
        id={id}
        className={`w-full min-h-screen ${
            noSnap ? "" : "snap-start"
        } flex flex-col justify-center items-center relative px-6 md:px-16 py-20 transition-colors duration-500
        ${isGlass ? "bg-transparent" : className} 
        `}
        initial={{ opacity: 0, y: 30 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: false, amount: 0.2 }}
        transition={{ duration: 0.6, ease: "easeOut" }}
    >
        {children}
    </motion.section>
);

export default SectionWrapper;
