// SELECT 1
// Išrenkamos visos medžiagos, kurias naudojo kažkoks darbuotojas.
SELECT SQL_NO_CACHE DISTINCT Materials.name FROM JobsRegister LEFT JOIN JobsRegister_Materials ON JobsRegister.jobsRegisterId  = JobsRegister_Materials.jobsRegisterId LEFT JOIN Materials ON Materials.materialId = JobsRegister_Materials.materialId WHERE JobsRegister.kkTechnicianId = 224;

// SELECT 2
// Suskaičiuojama, kiek kartų atlikta kiekviena paslauga
SELECT SQL_NO_CACHE Services.name, COUNT( Services.serviceId ) 
FROM Services
LEFT JOIN JobsRegister_Services ON Services.serviceId = JobsRegister_Services.serviceId
GROUP BY Services.serviceId

// SELECT 3
// Atvaizduojamos visos kiekvienoje paslaugoje panaudotos medžiagos (LIMIT 5 nes ant neindeksuotos duombazės vykdo labai ilgai)
SELECT SQL_NO_CACHE Materials.name, GROUP_CONCAT( Services.name ) 
FROM Materials
LEFT JOIN JobsRegister_Materials ON Materials.materialId = JobsRegister_Materials.materialId
LEFT JOIN JobsRegister_Services ON JobsRegister_Materials.jobsRegisterServiceId = JobsRegister_Services.jobsRegisterServiceId
LEFT JOIN Services ON JobsRegister_Services.serviceId = Services.serviceId
GROUP BY Materials.materialId
LIMIT 5

// UPDATE 1
// JobsRegister lentelėje, naujas stulpelis materialSum nustatomas į kiekį, tame darbe sunaudotų medžiagų.
UPDATE JobsRegister SET materialSum = 
(
	SELECT SUM(JobsRegister_Materials.count) 
	FROM JobsRegister_Materials
	WHERE JobsRegister_Materials.jobsRegisterId = JobsRegister.jobsRegisterId 
)

// UPDATE 2
// JobsRegister lentelėje, naujas stulpelis numberOfMaterials nustatomas į skaičių unikalių darbe panaudotų medžiagų.
UPDATE JobsRegister SET numberOfMaterials = 
( 
	SELECT COUNT( DISTINCT JobsRegister_Materials.materialId ) 
	FROM JobsRegister_Materials
	WHERE JobsRegister_Materials.jobsRegisterId = JobsRegister.jobsRegisterId 
)

// DELETE 1
// JobsRegsiter lentelėje, ištrinami visi įrašai, kurių kkTechnicianIndex reikšmė lyginė
DELETE FROM JobsRegister WHERE JobsRegister.kkTechnicianId % 2 =0

// DELETE 2
// JobsRegister_Materials lentelėje, ištrinami elementai, kurių count yra daugiau arba lygu vienam
DELETE FROM JobsRegister_Materials WHERE JobsRegister_Materials.count >=1
