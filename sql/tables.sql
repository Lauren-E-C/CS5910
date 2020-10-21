CREATE TABLE SystemUsers (
    IDNumber int,
    UEmail varchar(32),
    UPassword varchar(32),
    ULocked int,
    UType varchar(32),
    FName varchar(20),
    LName varchar(25),
    PhoneNum varchar(12),
    Street varchar(32),
    City varchar(32),
    State varchar(15),
    ZipCode int,
    Country varchar(32)
);

CREATE TABLE Students (
    StudentID int
);

CREATE TABLE StudentUndergraduate (
    StudentID int,
    RequiredCredits int,
    StudentType varchar(25)
);

CREATE TABLE StudentGraduate (
    StudentID int,
    RequiredCredits int,
    StudentType varchar(25)
);

CREATE TABLE StudentMajor (
    StudentID int,
    DeclaredDate datetime,
    MajorName varchar(32)
);

CREATE TABLE StudentMinor (
    StudentID int,
    DeclaredDate datetime,
    MinorName varchar(32)
);

CREATE TABLE Major (
    MajorName varchar(32),
    DepartmentID varchar(3),
    TypeOfDegree varchar(32)
);

CREATE TABLE Minor (
    MinorName varchar(32),
    DepartmentID varchar(3),
    MajorAffiliation varchar(32)
);

CREATE TABLE Faculty (
    FacultyID int,
    RoomID varchar(4),
    DepartmentID varchar(3),
    TimeInDepartment datetime
);

CREATE TABLE Enrollment (
    StudentID int,
    EnrollmentDate datetime,
    Grade varchar(2),
    CourseRegistrationNumber int
);

CREATE TABLE FacultyFullTime (
    FacultyID int
);

CREATE TABLE FacultyPartTime (
    FacultyID int
);

CREATE TABLE Researchers (
    ResearcherID int
);

CREATE TABLE Advisor (
    FacultyID int,
    StudentID int,
    AssignedDate datetime
);

CREATE TABLE SystemAdministrator (
    AdminID int
);

CREATE TABLE Department (
    DepartmentID varchar(3),
    DepartmentName varchar(32),
    ChairpersonIDNumber int,
    PhoneNumber varchar(12),
    BuildingName varchar(32),
    RoomID varchar(4)
);

CREATE TABLE Course (
    CourseID int,
    CourseName varchar(32),
    CourseDescription varchar(120),
    DepartmentID varchar(3),
    GraduateType varchar(25),
    Credits int
);

CREATE TABLE Section (
    CourseRegistrationNumber int,
    CourseID int,
    SectionNumber int,
    FacultyID int,
    TimeSlotNum int,
    SeatsCapacity int,
    RoomID varchar(4),
    BuildingName varchar(32),
    Semester varchar(15),
    Year int
);

CREATE TABLE Prerequisites (
    CourseID int,
    PreqCourseID varchar(4),
    GradeRequirement varchar(2)
);

CREATE TABLE Attendance (
    StudentID int,
    Status varchar(7),
    Date datetime,
    CourseRegistrationNumber int
);

CREATE TABLE ClassList (
    StudentID int,
    FacultyID int,
    TermNumber varchar(15),
    CourseRegistrationNumber int
);

CREATE TABLE CourseHistoryOfStudent (
    StudentID int,
    CourseRegistrationNumber int,
    GradeReceived varchar(2),
    TermNumber varchar(15),
    Year int
);

CREATE TABLE PeriodOfSection (
    PeriodNumber int,
    StartTime datetime,
    EndTime datetime
);

CREATE TABLE DayOfSection (
    NameOfDay varchar(15)
);

CREATE TABLE TimeSlot (
    TimeSlotNum int
);

CREATE TABLE PeriodOfTimeSlot (
    TimeSlotNum int,
    NameOfDay varchar(15)
);

CREATE TABLE DayOfTimeSlot (
    TimeSlotNum int,
    NameOfDay varchar(15)
);

CREATE TABLE YearOfSemester (
    TermNumber varchar(15),
    Year int,
    Session varchar(25)
);

CREATE TABLE Building (
    BuildingIDNumber varchar(3),
    BuildingName varchar(32)
);

CREATE TABLE Room (
    RoomID varchar(4),
    BuildingIDNumber varchar(3),
    RoomSize int,
    RoomType varchar(12)
);

CREATE TABLE MajorRequirements (
    MajorName varchar(32),
    GradeRequirement varchar(2),
    CourseID int
);

CREATE TABLE MinorRequirements (
    MinorName varchar(32),
    GradeRequirement varchar(2),
    CourseID int
);

CREATE TABLE Holds (
    HoldName varchar(32),
    TypeOfHold varchar(32),
    DescriptionOfHold varchar(32)
);

CREATE TABLE StudentHolds (
    StudentID int,
    HoldName varchar(32)
);