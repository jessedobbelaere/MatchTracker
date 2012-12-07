//
//  LoginViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 7/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "LoginViewController.h"
#import "User.h"

@interface LoginViewController ()
- (void)onLogin:(QButtonElement *)buttonElement;
- (void)onAbout;
@end

@implementation LoginViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

+ (QRootElement *)createLoginForm
{
    QRootElement *root = [[QRootElement alloc] init ];
    root.title = @"Test";
    root.controllerName = @"LoginViewController";
    root.grouped = YES;
    QSection *section = [[QSection alloc] init];
    QLabelElement *label = [[QLabelElement alloc] initWithTitle:@"Kut" Value:@"Xcode!!!!"];

    [root addSection:section];
    [section addElement:label];
    
    return root;
}

- (void)setQuickDialogTableView:(QuickDialogTableView *)aQuickDialogTableView
{
    [super setQuickDialogTableView:aQuickDialogTableView];
    
    //self.quickDialogTableView.backgroundView = nil;
    //self.quickDialogTableView.backgroundColor = [UIColor colorWithHue:0.1174 saturation:0.7131 brightness:0.8618 alpha:1.0000];
    self.quickDialogTableView.bounces = NO;
    self.quickDialogTableView.styleProvider = self;
    
    // JSON form
    ((QEntryElement *)[self.root elementWithKey:@"login"]).delegate = self;
}

- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    //self.navigationController.navigationBar.tintColor = [UIColor grayColor];
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"About" style:UIBarButtonItemStylePlain target:self action:@selector(onAbout)];
}

- (void)viewWillDisappear:(BOOL)animated
{
    [super viewWillDisappear:animated];
    self.navigationController.navigationBar.tintColor = nil;
}

- (void)onLogin:(QButtonElement *)buttonElement
{
    
    [[[UIApplication sharedApplication] keyWindow] endEditing:YES];
    [self loading:YES];
    User *info = [[User alloc] init];
    [self.root fetchValueUsingBindingsIntoObject:info];
    [self performSelector:@selector(loginCompleted:) withObject:info afterDelay:2];
}

- (void)loginCompleted:(User *)user
{
    [self loading:NO];
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Welcome" message:[NSString stringWithFormat: @"Hi %@, you are now logged in! Enjoy MatchTracker!", user.login] delegate:self cancelButtonTitle:@"Close" otherButtonTitles:nil];
    [alert show];
}

// Remove the login
- (void)alertView:(UIAlertView *)alertV didDismissWithButtonIndex:(NSInteger)buttonIndex
{
    NSLog(@"Go back...");
    [self dismissModalViewControllerAnimated:YES];
}






// Create about form
- (void)onAbout {
    QRootElement *details = [LoginViewController createAboutDetailsForm];
    [self displayViewControllerForRoot:details];
}

+ (QRootElement *)createAboutDetailsForm {
    QRootElement *details = [[QRootElement alloc] init];
    details.presentationMode = QPresentationModeModalForm;
    details.title = @"About MatchTracker";
    details.controllerName = @"AboutController";
    details.grouped = YES;
    
    // Create section Information
    QSection *section = [[QSection alloc] initWithTitle:@"Information"];
    [section addElement:[[QTextElement alloc] initWithText:@"MachTracker is an online competition creator and match tracker tool created by 3 ICT students during the course Projecten2 at KAHO Sint-Lieven."]];
    [details addSection:section];
    return details;
}



// Colors 
-(void) cell:(UITableViewCell *)cell willAppearForElement:(QElement *)element atIndexPath:(NSIndexPath *)indexPath{
    //cell.backgroundColor = [UIColor colorWithRed:0.9582 green:0.9104 blue:0.7991 alpha:1.0000];
    
    if ([element isKindOfClass:[QEntryElement class]] || [element isKindOfClass:[QButtonElement class]]){
        //cell.textLabel.textColor = [UIColor colorWithRed:0.6033 green:0.2323 blue:0.0000 alpha:1.0000];
    }
}

- (BOOL)QEntryShouldChangeCharactersInRangeForElement:(QEntryElement *)element andCell:(QEntryTableViewCell *)cell {
    NSLog(@"Should change characters");
    return YES;
}

- (void)QEntryEditingChangedForElement:(QEntryElement *)element andCell:(QEntryTableViewCell *)cell {
    NSLog(@"Editing changed");
}


- (void)QEntryMustReturnForElement:(QEntryElement *)element andCell:(QEntryTableViewCell *)cell {
    NSLog(@"Must return");
    
}


@end
