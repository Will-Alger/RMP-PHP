<?php

// school queries
$schoolDataQuery = "
        SELECT 
            name,
            state,
            numRatings,
            campusCondition,
            campusLocation,
            careerOpportunities,
            clubAndEventActivities,
            foodQuality,
            internetSpeed,
            libraryCondition,
            schoolReputation,
            schoolSafety,
            schoolSatisfaction,
            socialActivities
        FROM schools WHERE legacyId = :schoolId";

$aggregateSchoolDataSql = "
        SELECT
           ROUND(avg(numRatings),2) as avgNumRatings,
           ROUND(avg(campusCondition),2) as avgCampusCondition,
           ROUND(avg(campusLocation),2) as avgCampusLocation,
           ROUND(avg(careerOpportunities),2) as avgCareerOpportunities,
           ROUND(avg(clubAndEventActivities),2) as avgClubAndEventActivities,
           ROUND(avg(foodQuality),2) as avgFoodQuality,
           ROUND(avg(internetSpeed),2) as avgInternetSpeed,
           ROUND(avg(libraryCondition),2) as avgLibraryCondition,
           ROUND(avg(schoolReputation),2) as avgSchoolReputation,
           ROUND(avg(schoolSafety),2) as avgSchoolSafety,
           ROUND(avg(schoolSatisfaction),2) as avgSchoolSatisfaction,
           ROUND(avg(socialActivities),2) as avgSocialActivities
        FROM schools";

// teacher queries
$aggregateTeacherSql = "
    SELECT
        ROUND(avg(avgRating), 2) as avgRating, 
        ROUND(avg(avgDifficulty), 2) as avgDifficulty,
        ROUND(avg(wouldTakeAgainPercent), 2) as 'avgWouldTakeAgain%',
        ROUND(avg(numRatings), 2) as avgNumRatings
    FROM teachers
    WHERE schoolId = :schoolId";
