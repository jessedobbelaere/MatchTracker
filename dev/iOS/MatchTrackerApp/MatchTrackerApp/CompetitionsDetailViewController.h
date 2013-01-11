//
//  CompetitionsDetailViewController.h
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Competition.h"

@interface CompetitionsDetailViewController : UITableViewController

@property (strong, nonatomic) Competition *competition;

// Form
@property (weak, nonatomic) IBOutlet UILabel *lblName;
@property (weak, nonatomic) IBOutlet UITextView *txtDescription;
@property (weak, nonatomic) IBOutlet UILabel *lblSportType;
@property (weak, nonatomic) IBOutlet UILabel *lblPlace;
@property (weak, nonatomic) IBOutlet UILabel *lblDate;
@property (weak, nonatomic) IBOutlet UILabel *lblScores;
@property (weak, nonatomic) IBOutlet UILabel *lblTeams;

@end
