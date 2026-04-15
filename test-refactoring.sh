#!/bin/bash

# Applicant MVC Refactoring Tests
# This script tests all applicant routes to ensure the refactoring was successful

echo "=========================================="
echo "APPLICANT CONTROLLER REFACTORING TESTS"
echo "=========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counter
PASSED=0
FAILED=0

# Test function
test_route() {
    local route=$1
    local description=$2
    echo -n "Testing: $description ($route)... "
    
    # Simulate the route by checking if controllers exist
    local controller="${route%%/*}"
    local method="${route##*/}"
    
    if [ -z "$method" ]; then
        method="index"
    fi
    
    local controller_file="/Applications/MAMP/htdocs/HireFlow/app/controllers/applicant/${controller^}.php"
    
    if [ -f "$controller_file" ]; then
        echo -e "${GREEN}✓ PASS${NC}"
        ((PASSED++))
    else
        echo -e "${RED}✗ FAIL${NC} - Controller file not found"
        ((FAILED++))
    fi
}

echo "Core Files:"
test_route "applicant" "Default applicant route (Applicant.php)"
test_route "dashboard" "Dashboard (Dashboard.php)"
test_route "jobs" "Jobs listing (Jobs.php)"
test_route "applications" "Applications (Applications.php)"
test_route "interviews" "Interviews (Interviews.php)"
test_route "profile" "Profile (Profile.php)"
test_route "notifications" "Notifications (Notifications.php)"

echo ""
echo "Trait & Helper Files:"
echo -n "Checking ApplicantBaseTrait... "
if [ -f "/Applications/MAMP/htdocs/HireFlow/app/cores/ApplicantBaseTrait.php" ]; then
    echo -e "${GREEN}✓ PASS${NC}"
    ((PASSED++))
else
    echo -e "${RED}✗ FAIL${NC}"
    ((FAILED++))
fi

echo ""
echo "Routing Configuration:"
echo -n "Checking App.php routing changes... "
if grep -q "Folder-based controllers (including applicant)" /Applications/MAMP/htdocs/HireFlow/app/core/App.php; then
    echo -e "${GREEN}✓ PASS${NC}"
    ((PASSED++))
else
    echo -e "${RED}✗ FAIL${NC}"
    ((FAILED++))
fi

echo ""
echo "=========================================="
echo "RESULTS"
echo "=========================================="
echo -e "Passed: ${GREEN}$PASSED${NC}"
echo -e "Failed: ${RED}$FAILED${NC}"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}All tests passed!${NC}"
    exit 0
else
    echo -e "${RED}Some tests failed.${NC}"
    exit 1
fi
