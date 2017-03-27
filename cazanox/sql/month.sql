SELECT DATE_FORMAT(date, '%a') as weekday,
	DATE_FORMAT(date, '%d/%m/%Y') AS date,
    DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(end)-TIME_TO_SEC(begin))), '%H:%i') as 'total hours',
    CASE WHEN  WEEKDAY(date) < 5 THEN '8.40' END AS must,
    DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(end)-TIME_TO_SEC(begin))), '%H:%i') - '8.40' AS total,
    CASE WHEN date BETWEEN Absences.begin AND Absences.end THEN '8.40' END AS abscence
  FROM WorkingHours
  RIGHT JOIN Calendar ON (DATE(begin) = date AND idEmployee = '1')
  WHERE YEAR(date) = '2014' AND MONTH(date) = '12'
GROUP BY DATE;

SELECT end AS date, description, status FROM fleXtime.Absences WHERE begin BETWEEN begin and end AND status = 'Approved';

SELECT * FROM fleXtime.Absences WHERE begin <= '2014-12-31' AND end >= '2014-12-01';